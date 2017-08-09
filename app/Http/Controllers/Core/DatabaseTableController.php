<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DatabaseTableController extends Controller
{
    public function index()
    {
    	$tables = [];
    	$i = 0;
    	foreach ($this->getTables() as $key => $table) {
    		$columns = array();
	        $info = \DB::select("SHOW TABLE STATUS FROM `". env('DB_DATABASE', 'forge') . "` WHERE `name` = '" . $table . "'");
	        if(count($info)>=1)
	        {
	            $info = $info[0];
	        }
	        $tables[$i]['name'] = $table;
	        $tables[$i]['info'] = $info;
	        if($table != null)
	        {
	            $conn = \DB::getPdo();
	            foreach($conn->query("SHOW FULL COLUMNS FROM `$table`") as $column)
	            {
	                $columns[] = $column;
	            }
	            $tables[$i]['columns'] = $columns;
	        }
	        $i++;
    	}
    	return view('core.table.index',['tables'=>$tables]);
    }

    public function create($table = null)
    {
    	$columns = array();
        $info = \DB::select("SHOW TABLE STATUS FROM `". env('DB_DATABASE', 'forge') . "` WHERE `name` = '" . $table . "'");
        if(count($info)>=1)
        {
            $info = $info[0];
        }
        if($table != null)
        {
            $conn = \DB::getPdo();
            foreach($conn->query("SHOW FULL COLUMNS FROM `$table`") as $column)
            {
                $columns[] = $column;
            }
        }
  
        $data['default'] = array('NULL','USER_DEFINED','CURRENT_TIMESTAMP');
        $data['tbtypes'] = array('bigint','binary','bit','blob','bool','boolean','char','date','datetime','decimal','double','enum','float','int','longblob','longtext','mediumblob','mediuminit','mediumtext','numerice','real','set','smallint','text','time','timestamp','tinyblob','tinyint','tinytext','varchar','varbinary','year');
        $data['engine'] = array('InnoDB','MyISAM');
        $data['info'] = $info;     
        $data['columns'] = $columns;
        $data['table'] = $table;
        $data['title'] = $table ? 'Edit Table' : 'New Table';
        $data['action'] = $table == null ? "core/table" : "core/table/{$table}/update";
    	return view('core.table.create', $data);
    }

    public function store(Request $request)
    {
        $table  = $request->input('table_name');
        $engine = $request->input('engine') ? $request->input('engine') : 'InnoDB';

        $info = \DB::select("SHOW TABLE STATUS FROM `" . env('DB_DATABASE', 'forge') . "` WHERE `name` = '" . $table . "'");
        if(count($info) == 0)
        {
            $comma = ",";
            $sql = "CREATE TABLE `" . $table . "` (\n";
            $fields = $request->fields;
            foreach ($fields as $key => $field) {
                if(!empty($field) )
                {
                    $type       = $request->types[$key];
                    $lenght     = $this->lenght($type,$request->lenghts[$key]);
                    $default    = $request->defaults[$key];
                    $null       = (isset($request->null[$key]) ? 'NOT NULL' : '') ;
                    $ai         = (isset($request->ai[$key]) ? 'AUTO_INCREMENT' : '') ;
                    if($field != 'created_at' && $field != 'updated_at'){
                        $sql .= $this->getFieldSql($field, $type, $lenght, $default, $null, $ai);  
                    }
                }
            }
            $sql .= $this->getFieldSql('created_at','datetime', $this->lenght($type,'6'), '', '', '');
            $sql .= $this->getFieldSql('updated_at','datetime', $this->lenght($type,'6'), '', '', '');
            $primarykey = $request->input('key');
            if(count( $primarykey ) >=1 )
            {
                $ai = array();
                for($i=0; $i<count($fields);$i++)
                {
                    if(isset($request->key[$i]))
                    {
                        $ai[] = $request->fields[$i]; 
                    }
                }
                $sql .= 'PRIMARY KEY (`'.implode('`,`', $ai).'`)'. "\n";    
            }
            $sql .= ") ENGINE=$engine DEFAULT CHARSET=utf8 ";
            $conn = \DB::getPdo();
            $conn->query($sql);

            return redirect('core/table/create')->with(['message'=>'The table has been created successfully.','status'=>'success']);
        }
        return redirect('core/table/create')->with(['message'=>'This table is already exist.','status'=>'error']);
    }

    public function update(Request $request, $table)
    {
    	$info = \DB::select("SHOW TABLE STATUS FROM `" . env('DB_DATABASE', 'forge') . "` WHERE `name` = '" . $table . "'");
        if(count($info)>=1)
        {
            $info = $info[0];
            $table_name = trim($request->input('table_name'));
            $engine = trim($request->input('engine'));
            if($table_name != $info->Name )
            {
                $sql = "RENAME TABLE `" . $info->Name . "` TO  `" . $table_name . "`";  
                try {
                    $conn = \DB::getPdo();
                    $conn->query( $sql );
                }catch(Exception $e){
                    dd($e);
                }               
            }
            if($engine != $info->Engine )
            {
                $sql = "ALTER TABLE `" . $table_name . "` ENGINE = " . $engine;
                try {
                    $conn = \DB::getPdo();
                    $conn->query( $sql );
                }catch(Exception $e){
                    
                }                 
            }
            $module = \DB::table('tb_module')->where('module_db', $table)->first();
	        if($module) {
	        	$module->module_db = $table_name;
	        	$module->update();
	        	return redirect('core/model/rebuild/'.$module->module_id.'?return='.url('core/table/'.$table_name.'/edit'));
	        }
            return redirect('core/table/'.$table_name.'/edit')->with(['message'=>'The table has been changed successfully.','status'=>'success']);
        }       
    }

    public function getField($table, Request $request)
    {
        $data = $request->all();
        $conn = \DB::getPdo();
        foreach($conn->query("SHOW FULL COLUMNS FROM `{$table}`") as $column)
        {
            $columns[] = $column;
        }
        $data['fields'] = $columns;
        $data['table'] = $table;
        $data['tbtypes'] = array('bigint','binary','bit','blob','bool','boolean','char','date','datetime','decimal','double','enum','float','int','longblob','longtext','mediumblob','mediuminit','mediumtext','numerice','real','set','smallint','text','time','timestamp','tinyblob','tinyint','tinytext','varchar','varbinary','year');
        return view('core.table.field',$data);
    }

    public function postField($table, Request $request)
    {
        $field      = $request->input('field');
        $type       = $request->input('type');
        $lenght     = self::lenght($type,$request->input('lenght'));
        $default    = $request->input('default');
        $null       = (!is_null($request->input('null')) ? 'NOT NULL' : '') ;
        $ai         = (!is_null($request->input('ai')) ? 'AUTO_INCREMENT' : '') ;
        if ($null != "" and $ai =='AUTO_INCREMENT') {
            $default = '';  
        } elseif ($null == "" && $default !='') {
            $default = "DEFAULT '".$default."'";
        } else {     
            if($null == 'NOT NULL')   
            {
                $default = "";
            }  else {
                $default = " DEFAULT NULL ";
            }           
        }
        $column_position = $request->input('position_field');
        $position = $column_position != '' ? ' AFTER '.$column_position : ($request->input('position') ? ' FIRST ' : '');
        $currentfield = $request->input('currentfield');
        if( $currentfield !='')
        {
            if($currentfield == $field )
            {
                $sql = " ALTER TABLE `" . $table . "` MODIFY COLUMN `$field` $type  $lenght   $null $default $ai $position";
            }   else {
                 $sql = " ALTER TABLE `" . $table . "` CHANGE  `$currentfield` `$field`  $type $lenght   $null $default $ai $position";  
            }

        } else {
            $sql = " ALTER TABLE `" . $table . "` ADD COLUMN `$field` $type  $lenght   $null $default $ai $position";
        }

        try {
            $conn = \DB::getPdo();
            $conn->query( $sql );
        }catch(Exception $e){

        }
        $module = \DB::table('tb_module')->where('module_db', $table)->first();
        if($module) {
        	return redirect('core/model/rebuild/'.$module->module_id.'?return='.url('core/table/'.$table.'/edit'));
        }
        return redirect('core/table/'.$table.'/edit')->with(['message'=>'The table has been changed successfully.','status'=>'success']);
    }

    public function removeField($table, $field)
    {
        if($field == 'created_at' || $field == 'updated_at')
        {
            return redirect('core/table/'.$table.'/edit')->with(['message'=>"This {$field} field cann't remove.",'status'=>'error']);
        }
        $sql = "ALTER TABLE `" . $table . "` DROP COLUMN `" . $field . "`";
        try {
            $conn = \DB::getPdo();
            $conn->query( $sql );
        }catch(Exception $e){

        }
        $module = \DB::table('tb_module')->where('module_db', $table)->first();
        if($module){
        	return redirect('core/model/rebuild/'.$module->module_id.'?return='.url('core/table/'.$table.'/edit'));
        }
        return redirect('core/table/'.$table.'/edit')->with(['message'=>'The table has been changed successfully.','status'=>'success']);
    }

    public function dropTable($table = null, Request $request)
    {
    	if($table != null) {
	    	$sql = 'DROP TABLE IF EXISTS `' . $table . '`';
	        $conn = \DB::getPdo();
	        $conn->query($sql);
    	}

    	if($request->tables) {
    		foreach ($request->tables as $table) {
    			$sql = 'DROP TABLE IF EXISTS `' . $table . '`';
		        $conn = \DB::getPdo();
		        $conn->query($sql);
    		}
    	}
    	return redirect('core/table')->with(['message'=>'The table has been removed successfully.','status'=>'success']);
    }

    public function dropView($view = null)
    {
    	if($view != null) {
	    	$sql = 'DROP VIEW IF EXISTS `' . $view . '`';
	        $conn = \DB::getPdo();
	        $conn->query($sql);
    	}
    	return redirect('core/table')->with(['message'=>'The table has been removed successfully.','status'=>'success']);
    }

    public function getImport()
    {
        return view('core.table.import');
    }

    public function postImport(Request $request)
    {
        $rules = array(
            'sql'    => "required",
        );
        $validator = \Validator::make($request->all(), $rules);    
        if ($validator->passes()) {
            $templine = '';
            // Read in entire file
            $lines = file($_FILES['sql']['tmp_name']);

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
            
            return redirect('core/table')->with(['message'=>'The sql file has been imported successfully.','status'=>'success']);

        }else{
            return redirect('core/table')->with(['message'=>$validator->errors()->first('sql'),'status'=>'error'])->withErrors($validator);
        }
    }

    public function getView()
    {
    	return view('core.table.view');
    }

    public function postView(Request $request)
    {
    	$name = $request->name;
    	$algorithm = $request->algorithm;
    	$as = $request->as;
    	$sql = 'CREATE ALGORITHM = '.$algorithm.' VIEW `'.$name.'` AS '. $as;
        $conn = \DB::getPdo();
        $conn->query($sql);
        return redirect('core/table')->with(['message'=>'The view has been created successfully.','status'=>'success']);
    }

    function getTables()
    {
        $tables = [];
        $dbname = 'Tables_in_'.env('DB_DATABASE', 'forge'); 
        $result = \DB::select("SHOW TABLES FROM ".env('DB_DATABASE', 'forge'));
        foreach($result as $table)
        {
            $tables[$table->{$dbname}] = $table->{$dbname};
        }
        unset($tables['migrations']);
        unset($tables['oauth_access_tokens']);
        unset($tables['oauth_auth_codes']);
        unset($tables['oauth_clients']);
        unset($tables['oauth_personal_access_clients']);
        unset($tables['oauth_refresh_tokens']);
        unset($tables['tb_users']);
        unset($tables['tb_module']);
        unset($tables['tb_menu']);
        unset($tables['tb_logs']);
        unset($tables['tb_groups_access']);
        unset($tables['tb_groups']);
        unset($tables['tb_logs']);
        unset($tables['tb_pages']);
        return $tables;
    }

    function getFieldSql($field, $type, $lenght, $default, $null, $ai)
    {
        if ($null != "" and $ai =='AUTO_INCREMENT') {
            $default = '';  
        } elseif ($null == "" && $default !='') {
            $default = "DEFAULT '".$default."'";
        } else {     
            if($null == 'NOT NULL')   
            {
                $default = " ";
            }  else {
                $default = " DEFAULT NULL ";
            }           
            
        }

        return " `$field` $type $lenght  $null $default $ai ". ",\n";  
    }

    function lenght( $type , $lenght)
    {
        if($lenght == '')
        {
            switch (strtolower(trim( $type))) {
                default ;
                    $lenght = '';
                    break;
                case 'bit':
                   $lenght = '(1)';
                    break;
                case 'tinyint':
                    $lenght = '(4)';
                    break;
                case 'smallint':
                    $lenght = '(6)';
                    break;
                case 'mediumint':
                   $lenght = '(9)';
                    break;
                case 'int':
                    $lenght = '(11)';
                    break;
                case 'bigint':
                   $lenght = '(20)';
                    break;
                case 'decimal':
                    $lenght = '(10,0)';
                    break;
                case 'char':
                    $lenght = '(50)';
                    break;
                case 'varchar':
                   $lenght = '(255)';
                    break;
                case 'binary':
                    $lenght = '(50)';
                    break;
                case 'varbinary':
                    $lenght = '(255)';
                    break;
                case 'year':
                    $lenght = '(4)';
                    break;

            }
            return $lenght;
        } else {
             return "( $lenght )" ;
        }       
    }

    function findPrimarykey( $table )
    {
        // show columns from members where extra like '%auto_increment%'"
        $query = "SHOW columns FROM `{$table}` WHERE extra LIKE '%auto_increment%'";
        $primaryKey = '';
        foreach(\DB::select($query) as $key)
        {
            $primaryKey = $key->Field;
        }
        return $primaryKey;    
    }
}
