<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
	public function setup($config, Request $request)
	{
		$config = \SiteHelpers::CF_decode_json($config);
		if(!$config) return response()->json('This config file is not a valid.',400);
		if(\Auth::check()){
			return redirect('/dashboard');
		} else {
			if(file_exists(base_path('dev.apitoolz.sql')))
			{
				$this->createDatabase($config['application']['database_name']);
			}
			if($request->expectsJson())
			{
				$config['message'] = 'Application has been configured successfully.';
				return response()->json($config);
			}
			return redirect('https://'.$config['application']['domain']);
		}
	}

	function createDatabase($database_name){

		$conn = new \mysqli(env('DB_HOST', 'localhost'), env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''));

		// Create database
		$sql = "CREATE DATABASE ".$database_name." CHARACTER SET utf8 COLLATE utf8_general_ci;";
		if ($conn->query($sql) === TRUE) {
			$conn->close();
		}

		// Create connection
		$connwithdb = new \mysqli(env('DB_HOST', 'localhost'), env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''), $database_name );
		// Check connection
		if ($connwithdb->connect_error) {
		    dd("Connection failed: " . $connwithdb->connect_error);
		}

		$templine = '';
	    // Read in entire file
	    $lines = file(base_path('dev.apitoolz.sql'));

	    // Loop through each line
	    foreach ($lines as $line)
	    {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';')
            {
                // Perform the query
                $connwithdb->query($templine) or dd('Error performing query \'<strong>' . $templine . '\': ' . $connwithdb->error . '<br /><br />');
                // Reset temp variable to empty
                $templine = '';
            }
        }
        $connwithdb->close();
        @unlink(base_path('dev.apitoolz.sql'));
		return false;
	}

	function createVHost($host)
	{
		$vhost = "<VirtualHost *:80>\n".
        		"	ServerAdmin webmaster@localhost\n".
        		"	ServerName ".str_replace('.conf', '', $host)."\n".
        		"   DocumentRoot /var/www/apitoolz.com/public_html/public\n".
        		"	<Directory /var/www/apitoolz.com/public_html>\n".
        		"   	Options Indexes FollowSymLinks\n".
        		"   	AllowOverride All\n".
        		"   	Order allow,deny\n".
        		"   	allow from all\n".
        		"   	Require all granted\n".
        		"	</Directory>\n".
        		"	ErrorLog \${APACHE_LOG_DIR}/error.log\n".
        		"	CustomLog \${APACHE_LOG_DIR}/access.log combined\n".
				"</VirtualHost>\n";

		$vhost_ssl = "<IfModule mod_ssl.c>\n".
					"	<VirtualHost _default_:443>\n".
					"		ServerAdmin webmaster@localhost\n".
					"		ServerName ".str_replace('.conf', '', $host).":443\n".
					"       ServerAlias ".str_replace('.conf', '', $host).":443\n".
					"       DocumentRoot /var/www/apitoolz.com/public_html/public\n".
					"       <Directory /var/www/apitoolz.com>\n".
					"       	Options Indexes FollowSymLinks MultiViews\n".
					"       	AllowOverride All\n".
					"       	Order allow,deny\n".
					"       	allow from all\n".
					"       </Directory>\n".
					"		ErrorLog \${APACHE_LOG_DIR}/error.log\n".
					"		CustomLog \${APACHE_LOG_DIR}/access.log combined\n".
					"		SSLEngine on\n".
					"		SSLCertificateFile /etc/apache2/ssl/19d7f74468392b86.crt\n".
					"       SSLCertificateKeyFile /etc/apache2/ssl/apitoolz.key\n".
					"       SSLCACertificateFile /etc/apache2/ssl/gd_bundle-g2-g1.crt\n".
					"		<FilesMatch \"\.(cgi|shtml|phtml|php)\$\">\n".
					"				SSLOptions +StdEnvVars\n".
					"		</FilesMatch>\n".
					"		<Directory /usr/lib/cgi-bin>\n".
					"				SSLOptions +StdEnvVars\n".
					"		</Directory>\n".
					"	</VirtualHost>\n".
					"</IfModule>\n";

		$ssl_host = 'ssl-'.$host;
		$vhost_file = '/etc/apache2/sites-available/'.$host;
		$vhost_ssl_file = '/etc/apache2/sites-available/'.$ssl_host;

		file_put_contents($vhost_file, $vhost);  
		file_put_contents($vhost_ssl_file, $vhost_ssl);

		shell_exec("a2ensite ".$host);
		shell_exec("a2ensite ".$ssl_host);
		shell_exec("sudo /etc/init.d/apache2 reload");
	}

	public function getConnection()
	{
		return view('core.settings.connection');
	}

    public function getGeneral()
    {
    	foreach(timezone_abbreviations_list() as $time){
	        foreach($time as $val){
                if(isset($val['timezone_id'])){
                   $timezone[] = $val['timezone_id'];
                }
	        }
		}
		$timezone = array_unique($timezone);
    	return view('core.settings.general',['itemzone'=>$timezone]);
    }

    public function getSecurity()
    {
    	$groups = \DB::table('tb_groups')->get();
    	$modules = \DB::table('tb_module')->where('module_type','!=','core')->get();
    	return view('core.settings.security',['groups'=>$groups,'modules'=>$modules]);
    }

    public function postConnection(Request $request)
	{
		$remote_key_file = '';
		if(!is_null($request->file('cnf_remote_key')))
		{
			$file = $request->file('cnf_remote_key'); 
		 	$destinationPath = storage_path(); 
			$remote_key_file = $destinationPath.'/'.$file->getClientOriginalName();
			$file->move($destinationPath, $file->getClientOriginalName());
		}
		$input = $request->all();
		$conf['REMOTE_HOST'] = $input['cnf_remote_host'];
		$conf['REMOTE_USERNAME'] = $input['cnf_remote_username'];
		$conf['REMOTE_PASSWORD'] = $input['cnf_remote_password'];
		$conf['REMOTE_KEY'] =  $remote_key_file !=''  ? $remote_key_file : env('REMOTE_KEY','');
		$conf['REMOTE_KEYTEXT'] = $input['cnf_remote_keytext'];	
		$conf['REMOTE_KEYPHRASE'] = $input['cnf_remote_keyphrase'];
		$conf['REMOTE_AGENT'] = $input['cnf_remote_agent'];	
		$conf['REMOTE_TIMEOUT'] = $input['cnf_remote_timeout'];		
		
		$this->editEnv($conf);
		return redirect(url()->previous())->with(['message'=>'Connection has been saved successfully.','status'=>'success']);
	}

    public function postGeneral(Request $request)
    {
    	$logo = '';
    	if(!is_null($request->file('logo')))
		{
			$file = $request->file('logo'); 
		 	$destinationPath = public_path().'/uploads'; 
			$filename = $file->getClientOriginalName();
			$extension =$file->getClientOriginalExtension(); 
			$logo = 'backend-logo.'.$extension;
			$uploadSuccess = $file->move($destinationPath, $logo);
		}
		$analytic_file = '';
		if(!is_null($request->file('analytic_view_file')))
		{
			$file = $request->file('analytic_view_file'); 
		 	$destinationPath = storage_path('app/laravel-google-analytics'); 
			$analytic_file = $file->getClientOriginalName();
			$file->move($destinationPath, $analytic_file);
		}
		$input = $request->all();
		if(env('APP_URL') != $input['cnf_domain'])
		{
			$this->createVHost($input['cnf_domain'].'.conf');
		}
		$conf['APP_URL'] = $input['cnf_domain'];
		$conf['APP_NAME'] = $input['cnf_appname'];
		$conf['APP_DESC'] = $input['cnf_appdesc'];
		$conf['APP_COMNAME'] = $input['cnf_comname'];
		$conf['APP_EMAIL'] = $input['cnf_email'];	
		$conf['APP_TIME'] = $input['cnf_timezone'];
		$conf['APP_METAKEY'] = $input['cnf_metakey'];	
		$conf['APP_METADESC'] = $input['cnf_metadesc'];		
		$conf['APP_LOGO'] = $logo !=''  ? $logo : env('APP_LOGO');
		$conf['ANALYTICS_VIEW_ID'] = $input['analytic_view_id'];
		$conf['ANALYTICS_VIEW_FILE'] = $analytic_file !=''  ? $analytic_file : env('ANALYTICS_VIEW_FILE');
		
		$this->editEnv($conf);
		return redirect(url()->previous())->with(['message'=>'General settings has been saved successfully.','status'=>'success']);

    }

    public function postSecurity(Request $request)
    {
   		$conf['APP_GROUP'] = $request->cnf_group;	
		$conf['APP_ACTIVATION'] = $request->cnf_activation;
		$conf['APP_REGIST'] = $request->cnf_regist ? $request->cnf_regist : 'false';	
		$conf['APP_REDIRECT'] = $request->cnf_redirect;	
		$conf['APP_ALLOWIP'] = $request->cnf_allowip;
		$conf['APP_RESTRICIP'] = $request->cnf_restricip;
		$conf['APP_MAIL'] = $request->cnf_mail;	
		$conf['MAIL_DRIVER'] = $request->cnf_driver;
		$conf['MAIL_HOST'] = $request->cnf_mailhost;
		$conf['MAIL_PORT'] = $request->cnf_mailport;
		$conf['MAIL_USERNAME'] = $request->cnf_mailusername;
		$conf['MAIL_PASSWORD'] = $request->cnf_mailpassword;
		$conf['MAIL_ENCRYPTION'] = $request->cnf_mailencryption;
		$conf['MAIL_FROM_ADDRESS'] = $request->cnf_mailfromaddress;
		$conf['MAIL_FROM_NAME'] = $request->cnf_mailfromname;
		$this->editEnv($conf);
		return redirect(url()->previous())->with(['message'=>'Security settings has been saved successfully.','status'=>'success']);
    }

    public function changeMode($state)
    {
    	
    	if($state == 'true')
		{
			$this->editEnv(['APP_ENV'=> $state == "true" ? 'production': 'local']);
			\SSH::run([
				'sudo chown -R root:root '.base_path(),
	    		'sudo chown -R www-data:www-data '. base_path('storage'),
	    		'sudo chown -R www-data:www-data '. public_path(),
	    		'sudo chown -R root:root '. public_path('index.php'),
	    		'sudo chown -R root:root '. public_path('.htaccess'),
	    		'sudo chown -R root:root '. public_path('web.config'),
				'sudo chown -R root:root /etc/apache2/sites-enabled',
				'sudo chown -R root:root /etc/apache2/sites-available',
			]);
		}else{
			\SSH::run([
				'sudo chown -R www-data:www-data '. base_path(),
				'sudo chown -R www-data:www-data /etc/apache2/sites-enabled',
				'sudo chown -R www-data:www-data /etc/apache2/sites-available',
			]);
			$this->editEnv(['APP_ENV'=> $state == "true" ? 'production': 'local']);
		}
    	
    	return redirect(url()->previous());
    }

    public function editEnv($conf)
    {
    	// Update ENV value
    	foreach ($conf as $key => $val) {
    		$_ENV[$key] = $val;
    	}
    	// Create ENV file
    	$env = '';
    	foreach ($_ENV as $key => $value) {
    		$env .= "{$key}='{$value}'\n";
    	}
    	file_put_contents(base_path().'/.env', $env);
    }

    public function getEmail()
	{
		$regEmail = file_get_contents(base_path()."/resources/views/user/emails/registration.blade.php");
		$resetEmail = file_get_contents(base_path()."/resources/views/user/emails/auth/reminder.blade.php");
		return view('core.settings.email',['regEmail' => $regEmail,'resetEmail'=>$resetEmail]);
	}
	
	function postEmail( Request $request)
	{
		$rules = array(
			'regEmail'		=> 'required|min:10',
			'resetEmail'		=> 'required|min:10',				
		);	
		$validator = \Validator::make($request->all(), $rules);	
		if ($validator->passes()) 
		{
			$regEmailFile = base_path()."/resources/views/user/emails/registration.blade.php";
			$resetEmailFile = base_path()."/resources/views/user/emails/auth/reminder.blade.php";			
			$fp=fopen($regEmailFile,"w+"); 				
			fwrite($fp,$_POST['regEmail']); 
			fclose($fp);	
			
			$fp=fopen($resetEmailFile,"w+"); 				
			fwrite($fp,$_POST['resetEmail']); 
			fclose($fp);
			
			return redirect('core/settings/email')->with('message', 'Email has been updated successfully.')->with('status','success');	
			
		} else {
			return redirect('core/settings/email')->with('message', 'The following errors occurred')->with('status','error')
			->withErrors($validator)->withInput();
		}
	
	}
}
