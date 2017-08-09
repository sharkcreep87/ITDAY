<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Core\Pages;

class PageController extends Controller
{
	public function index()
	{
		$pages = Pages::all();
		return view('core.page.index',['pages'=>$pages]);
	}

	public function template()
	{
        $templates = $this->cURL("https://developers-162.apitoolz.com/api/template?search=status:equal:1");
		return view('core.page.template',['templates'=>$templates]);
	}

    function cURL($url, $val = array(), $method = 'GET'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => $method,
          CURLOPT_POSTFIELDS => json_encode($val),
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRjNjVlYjYzYzY1Y2MxMWE5Zjc3OWExNjk3NDViMjkwMmNhOWZlNjk0OGI3Y2RhZDRiYTNkYWQxZjA2MDI1OWVhNGM2Mzc2NTgwNWVjN2IyIn0.eyJhdWQiOiIzIiwianRpIjoiNGM2NWViNjNjNjVjYzExYTlmNzc5YTE2OTc0NWIyOTAyY2E5ZmU2OTQ4YjdjZGFkNGJhM2RhZDFmMDYwMjU5ZWE0YzYzNzY1ODA1ZWM3YjIiLCJpYXQiOjE0OTQyMjIyMzUsIm5iZiI6MTQ5NDIyMjIzNSwiZXhwIjoxNDk1NTE4MjM1LCJzdWIiOiIiLCJzY29wZXMiOltdfQ.BKgaU7pbKgWrYJq6W4NLq3zY355qO6wffxwxu41uI0RIdFW-tFuyoqr1wkmRpqPeyXpV5L_-lgfvlU6z8KLrplnSnCasSSPraLjXmSJ2wnX8GU6hOPF1wWaQb_47TFM-TDvLesJHpVK3gGWiHkpChskPOT1vPgkBP-OIDuhastvJ0_7gViA51JjN0eaE4iFfWnvgBaQMgxuWA-4z6m_sq7RV60nkZUDj2i4w62Fw5R4pBKhtyYw7F7EfQTosghtUWI3PBIGTj8LmWdFY7vmxJeeTYim3S1P3e09MuJWrX9x75QEA28CumHS7t2kEy2eaV38bRzc-4K2hxBIxnaBOzKs0XTIylIgtA0RreNSqP12jMXjuNggYmSDlGn6E3w24Ql96DRbNIaSy8J6jpl3APQN_fYs6kwGMwkenI2a5NSdkUXzZwvHsvgVSucYQCjwWoaGCMmOxwsmdHaMa2GM5frBwe0VryW70kyD1ZhIvZHqLJjBJSDM4JarfzMvYLRCXttvblBMAyrkzxEJKInj4IJtvGFqiP6EK6NdsPBY3-kL2m3ioFoheRbdnUB-dOUo3yYz3HHw0CKpN8zokWCrZxqaiEE_d4Hx2rIr_Yvps1A6ReXcB8jat20XjXzuuuzsTFDrXvjsRCc4jgZVU0b4EyjPe73XjDf_3-c281ykKRgY",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if($err)
        {
            return json_encode(['status'=>'error','message'=>$err]);
        }
        return json_decode($response);
    }

	public function create()
	{
		if(Pages::count() == 0) {
			$view = file_get_contents(base_path('resources/views/core/page/template/masterview.tpl'));
		}else{
			$view = file_get_contents(base_path('resources/views/core/page/template/contentview.tpl'));
		}
		$action = url('core/page/store');
		return view('core.page.create', ['action'=>$action, 'view'=>$view]);
	}

	public function store(Request $request, $id = null)
	{
		$validator =  \Validator::make($request->all(), [
            'title'=>'required|min:3|unique:tb_pages,title',
            'alias'=>'required|min:3|alpha|unique:tb_pages,alias',
            'url'=>'required|unique:tb_pages,url',
            'type'=>'required',
        ]);
        if($id != null || $id = $request->id){
        	$validator =  \Validator::make($request->all(), [
	            'title'=>'required|min:3|unique:tb_pages,title,'.$id,
	            'alias'=>'required|min:3|alpha|unique:tb_pages,alias,'.$id,
	            'url'=>'required|unique:tb_pages,url,'.$id,
	            'type'=>'required',
	        ]);
        }
        if($validator->passes())
        {
        	if($request->file('asset_files')){
        		$zip_path = $_FILES['asset_files']['tmp_name'];
		        $zip = new \ZipArchive; 
		        $zipres = $zip->open( $zip_path ); 
		        if( $zipres === TRUE){ 
		            $zip->extractTo( base_path('public') ); 
		            $zip->close(); 
		        }
        	}
            if($request->path && count($request->path) > 0) {
                foreach ($request->path as $i => $dir) {
                    file_put_contents(base_path($dir), $request->assets[$i]);
                }
            }

        	$dir_view = base_path("resources/views/pages");
        	if(!is_dir($dir_view)) mkdir($dir_view);
        	$codes = array(
                'alias'             => $request->alias,
                'title'             => $request->title,
            );

            $build_view       	= \SiteHelpers::blend($request->view,$codes);

            if($id == null) {
            	file_put_contents($dir_view."/{$codes['alias']}.blade.php" , $build_view);
            	$page = new Pages();
            	$page->title = $request->title;
	        	$page->alias = $request->alias;
	        	$page->url = $request->url;
	        	$page->method = $request->method;
	        	$page->meta_title = $request->meta_title;
	        	$page->meta_keywords = $request->meta_keywords;
	        	$page->meta_description = $request->meta_description;
	        	$page->auth = $request->auth ? 1 : 0;
	        	$page->status = $request->status;
	        	$page->type = $request->type;
	        	$page->save();
            }else{
            	file_put_contents($dir_view."/{$codes['alias']}.blade.php" , $build_view);
            	$page = Pages::find($id);
            	if($page) {
            		if($page->alias != $request->alias) {
            			@unlink($dir_view."/{$page->alias}.blade.php");
            		}
            	}
            	$page->title = $request->title;
	        	$page->alias = $request->alias;
	        	$page->url = $request->url;
	        	$page->method = $request->method;
	        	$page->meta_title = $request->meta_title;
	        	$page->meta_keywords = $request->meta_keywords;
	        	$page->meta_description = $request->meta_description;
	        	$page->auth = $request->auth ? 1 : 0;
	        	$page->status = $request->status;
	        	$page->type = $request->type;
	        	$page->update();
            }
            $this->createController();
            $this->createRouters();
            if($request->ajax()){
                return response()->json($page);
            }
        	if($request->apply)
				return redirect()->back()->with('message','Page has been saved successfully!')->with('status','success');
			else
				return redirect('core/page')->with('message','Page has been saved successfully!')->with('status','success');
        }
        else
        {
            if($request->ajax()){
                return response()->json($validator->errors(), 400);
            }
        	return redirect()->back()->with('message',$validator->errors())->with('status','error');
        }
	}

	public function edit($id)
	{
		$page = Pages::find($id);
		if($page){
        	$dir_view = base_path("resources/views/pages");
        	$view = $page->alias;
            $view = file_get_contents($dir_view."/{$view}.blade.php");
		}
		$action = url('core/page/'.$id.'/update');
		return view('core.page.create', ['action'=>$action, 'row'=>$page, 'view'=>$view]);
	}

    public function getFiles()
    {
        return view('core.page.filemanager');
    }

	public function getExport(Request $request)
	{
		if( count( $ids = $request->input('ids')) < 1){
            return redirect('core/page')->with('message','Can not find page')->with('status','error');   
        };
        $this->data['modules'] = \DB::table('tb_module')->where('module_type','!=','core')->get();
        $this->data['enc_id'] = implode(",", $ids);
        return view('core.page.export', $this->data);
	}

	public function doexport(Request $request)
	{
		ini_set('memory_limit', '-1');
        $ids = explode(",", $request->ids);
        $inc_paths = explode(",",str_replace("\r\n", ",", $request->inc_paths));
        if($request->file('sql_file')){
            $sql_file = $request->file('sql_file');
            $sql_path     = $sql_file->getrealpath();
            $sql_content = file_get_contents( $sql_path );
        }

        $cf_zip = new \ZipHelpers;
        $zip_name = date('Y-m-d-his').".zip";
        $zip_file ="./uploads/zip/".$zip_name;
        if(!is_dir("./uploads/zip/")) mkdir("./uploads/zip/");
		
		$_pages = \DB::table("tb_pages")->whereIn('id',$ids)->get();
		$setting['tb_pages'] = $_pages;
		foreach ($_pages as $page) {
			$class = ucwords($page->alias);
			$view = $page->alias;
			$cf_zip->add_data( "resources/views/pages/{$view}.blade.php", file_get_contents(base_path("resources/views/pages/{$view}.blade.php"))); 
		}
		
		$sql = "";
        $inc_modules = $request->module_ids;
        if(count($inc_modules) > 0) {
	        $_menus = [];
	        $_group_access = [];
	        $_modules = \DB::table("tb_module")->whereIn('module_id',$inc_modules)->get();
	        foreach ( $_modules as $n => $_module ){ 
	            $_modules[$n]->module_id = '';
	            $_menus[] = \DB::table("tb_menu")->where('module', $_module->module_name)->first();
	            $groupAccess = \DB::table("tb_groups_access")->where('module_id', $_module->module_name)->get();
	            foreach ($groupAccess as $access) {
	                $_group_access[] = $access;
	            }
	        }
	        $setting['tb_module'] = $_modules; 
	        $setting['tb_groups_access'] = $_group_access;
	        foreach ($_menus as $menu) {
	            $menu->parent_id = 0;
	            $setting['tb_menu'][] = $menu;
	        }

	        foreach ( $_modules as $n => $_module ){ 
	            $file = strtolower($_module->module_name); 
	            $cf_zip->add_data( "app/Http/Controllers/". ucwords($file)."Controller.php", file_get_contents( base_path()."/app/Http/Controllers/". ucwords($file)."Controller.php")) ; 
	            $cf_zip->add_data( "app/Http/Controllers/API/". ucwords($file)."APIController.php", file_get_contents( base_path()."/app/Http/Controllers/API/". ucwords($file)."APIController.php")) ; 
	            $cf_zip->add_data( "app/Models/". ucwords($file).".php", file_get_contents(base_path()."/app/Models/". ucwords($file).".php")) ;
	            $cf_zip->get_files_from_folder( base_path()."/resources/views/{$file}/","resources/views/{$file}/"); 
	            $tables[] = $_module->module_db;
	        }

	        $sql .= $this->backup_table(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'),$tables);
        	
        }

        foreach ($inc_paths as $path) {
            $path = trim(preg_replace("/(\r|\n)/", "", $path));
            if(is_dir(base_path($path))) {
                $cf_zip->get_files_from_folder( base_path($path) , $path );
            }elseif(is_file(base_path($path))) {
                $cf_zip->add_data($path, file_get_contents( base_path($path)));
            }
        }

        $cf_zip->add_data( ".setting", base64_encode(serialize($setting))); 
        $cf_zip->add_data( ".mysql" , $sql );

        
        // CHANGE END 
        $_zip = $cf_zip->archive( $zip_file ); 
        
        $cf_zip->clear_data();

        $headers = array(
            'Content-Type: application/zip',
        );

        return response()->download($zip_file, $zip_name, $headers);
	}

	function backup_table($host, $user, $pass, $name, $tables) {
        $mysqli = new \mysqli($host, $user, $pass, $name);
        $mysqli->select_db($name);
        $mysqli->query("SET NAMES 'utf8'");

        $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name.
        "`\r\n--\r\n\r\n\r\n";
        foreach($tables as $table) {
            if (empty($table)) {
                continue;
            }
            $result = $mysqli->query('SELECT * FROM `'.$table.'`');
            $fields_amount = $result->field_count;
            $rows_num = $mysqli->affected_rows;
            $res = $mysqli->query('SHOW CREATE TABLE '.$table);
            $TableMLine = $res->fetch_row();
            $content .= "\n\n".$TableMLine[1].";\n\n";
            $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);
            for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
                while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
                    if ($st_counter % 100 == 0 || $st_counter == 0) {
                        $content .= "\nINSERT INTO ".$table.
                        " VALUES";
                    }
                    $content .= "\n(";
                    for ($j = 0; $j < $fields_amount; $j++) {
                        $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                        if (isset($row[$j])) {
                            $content .= '"'.$row[$j].
                            '"';
                        } else {
                            $content .= '""';
                        }
                        if ($j < ($fields_amount - 1)) {
                            $content .= ',';
                        }
                    }
                    $content .= ")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                        $content .= ";";
                    } else {
                        $content .= ",";
                    }
                    $st_counter = $st_counter + 1;
                }
            }
            $content .= "\n\n\n";
        }
        $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
        ob_get_clean();
        return $content;
    }

     public function getImport(){
        return view('core.page.import');
    }

    public function postImport(Request $request){
        if($request->_url != null){
        	$zip_path = base_path("Tmpfile.zip");
        	file_put_contents($zip_path, fopen($request->_url, 'r'));
        }else{
        	$zip_path = $_FILES['installer']['tmp_name'];
        }
        $zip = new \ZipArchive; 
        $zipres = $zip->open( $zip_path ); 
        if( $zipres === TRUE){ 

            $zip->extractTo( base_path() ); 
            $zip->close(); 

            if(file_exists(base_path('.mysql'))){
                $templine = '';
                // Read in entire file
                $lines = file(base_path('.mysql'));

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
                        $conn = \DB::getPdo();
                        $conn->query($templine) or dd('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                        // Reset temp variable to empty
                        $templine = '';
                    }
                }
            }
            if(file_exists(base_path('.setting'))) {
                $setting_str = file_get_contents(base_path('.setting')); 
                $_setting = unserialize( base64_decode( $setting_str )); 
                
                if(isset($_setting['tb_pages'])) $this->store_setting($_setting['tb_pages'],'tb_pages','alias','id');
                if(isset($_setting['tb_module'])) $this->store_setting($_setting['tb_module'],'tb_module','module_name','module_id'); 
                if(isset($_setting['tb_groups_access'])) $this->store_setting($_setting['tb_groups_access'],'tb_groups_access','module_id','id', false); 
                if(isset($_setting['tb_menu'])) $this->store_setting($_setting['tb_menu'],'tb_menu','menu_name','menu_id');
            }
            $_tmpfile = ['.mysql','.setting', 'Tmpfile.zip'];
            foreach ( $_tmpfile as $_file ){ 
                @unlink( base_path().'/'. $_file ); 
            }
          
        } else { 
            $data['status'] = 0; 
            $data['error'] = "unzip error";
        }
        self::createController();
        self::createRouters();
        return redirect('core/page')->with(['message'=>'Successfully created.','status'=>'success']);
    }

    public function store_setting( $rows , $table_name , $where_field , $pk_field, $duplicate = true ) {

        foreach ( $rows as $k => $row ){
            $r = \DB::table($table_name)->where($where_field, $row->$where_field)->get();
            if(count( $r ) > 0 && $duplicate){
                unset( $row->{$pk_field} );
                \DB::table( $table_name )
                    ->where( $where_field , $row->$where_field )
                    ->update( (array) $row );
            
            } else {
                // insert
                $rows = array();
                unset( $row->{$pk_field} );
                foreach($row as $key=>$val){
                  if($val !='') $rows[$key] = $val;
                }
                $_id = \DB::table( $table_name )
                            ->insertGetId( (array) $rows );
            }
        }

    }

	public function destroy($id = null, Request $request)
	{
        $dir_view = base_path("resources/views/pages");
		if($id != null) {
			$page = Pages::find($id);
			if($page){
				$class = ucwords($page->alias);
				$view = $page->alias;
				@unlink($dir_view."/{$view}.blade.php");
				$page->delete();
			}
		}else{
			if($request->ids && is_array($request->ids)) {
				foreach ($request->ids as $id) {
					$page = Pages::find($id);
					if($page){
						@unlink($dir_view."/{$page->alias}.blade.php");
						$page->delete();
					}
				}
			}
		}
        $this->createController();
		$this->createRouters();
		return redirect('core/page')->with('message','Page(s) has been deleted successfully!')->with('status','success');
	}

    function createController()
    {
        $rows = \DB::table('tb_pages')->where('type','!=','master')->where('status', true)->get();
        $controller = file_get_contents(base_path('resources/views/core/page/template/frontpagecontroller.tpl'));
        $methods = "\n";
        foreach($rows as $row)
        {
            $alias = $row->alias;
            $methods .= "\tpublic function {$alias}(Request \$request)\n";
            $methods .= "\t{\n";
            $methods .= "\t\t\$this->data = \$this->getPageInfo('{$alias}');\n";
            $methods .= "\t\treturn view('pages.{$alias}')->with(\$this->data);\n";
            $methods .= "\t}\n\n";
        }
        $codes = array(
            'methods'       => $methods,
        );
        $build_controller   = \SiteHelpers::blend($controller,$codes);
        file_put_contents(base_path('app/Http/Controllers/FrontPageController.php'), $build_controller);
    }

	function createRouters()
    {
        $rows = \DB::table('tb_pages')->where('type','!=','master')->where('status', true)->get();
        /* Page Route Generate */
        $val  = "<?php\n"; 
        $auth = "\tRoute::group(['middleware' => ['web','auth']], function () {\n";
        foreach($rows as $row)
        {
            $alias = $row->alias;
            $url = $row->url;
            $method = $row->method;
            if($row->auth) {
                $auth .= "\t\tRoute::{$method}('{$url}', 'FrontPageController@{$alias}');\n";
            }else{
                $val .= "\tRoute::{$method}('{$url}', 'FrontPageController@{$alias}');\n";
            }
        }
        $auth .= "\t});\n";
        $val  .= $auth;
        $val  .= "?>";        
        file_put_contents(base_path('routes/pages.php'), $val);

        $rows = \DB::table('tb_module')->where('module_type','!=','core')->get();
        /* Module Route Generate */
        $val  =    "<?php\n"; 
        foreach($rows as $row)
        {
            $class = strtolower($row->module_name);
            $controller = ucwords($row->module_name).'Controller';
            $title = ucwords($row->module_name);
            $val .= "\n";
            $val .= "\t/* {$title} routes group */\n";
            $val .= "\tRoute::group(['prefix'=>'{$class}'], function() {\n";
            $val .= "\t\tRoute::get('/', '{$controller}@getIndex');\n";
            $val .= "\t\tRoute::get('update', '{$controller}@getUpdate');\n";
            $val .= "\t\tRoute::get('update/{id}', '{$controller}@getUpdate');\n";
            $val .= "\t\tRoute::get('show/{id}', '{$controller}@getShow');\n";
            $val .= "\t\tRoute::post('save', '{$controller}@postSave');\n";
            $val .= "\t\tRoute::post('delete/{id}', '{$controller}@postDelete');\n";
            $val .= "\t\tRoute::get('savepublic', '{$controller}@postSavepublic');\n";
            $val .= "\t\tRoute::get('download', '{$controller}@getDownload');\n";
            $val .= "\t\tRoute::get('search', '{$controller}@getSearch');\n";
            $val .= "\t\tRoute::get('comboselect', '{$controller}@getComboselect');\n";
            $val .= "\t\tRoute::get('removefiles', '{$controller}@getComboselect');\n";
            $val .= "\t\tRoute::post('filter', '{$controller}@postFilter');\n";
            $val .= "\t\tRoute::get('lookup/{master_detail}', '{$controller}@getLookup');\n";
            $val .= "\t});\n";
        }
        $val .= "\n?>";        
        file_put_contents(base_path('routes/routes.php'), $val);
        
        /* API Route Generate */
        $template = base_path('resources/views/core/template');
        $apiroutes = file_get_contents(  $template.'/apiroutes.tpl' );
        $resource = "\n";
        foreach($rows as $row)
        {
            $class = strtolower($row->module_name);
            $controller = 'API\\'.ucwords($row->module_name).'APIController';
            $resource .= "\tRoute::resource('{$class}', '{$controller}');\n";      
        }
        $build_routers = \SiteHelpers::blend($apiroutes,['apiroutes'=>$resource]);
        file_put_contents(base_path('routes/api.php'), $build_routers);
    
        return true;    
        
    }  

}
