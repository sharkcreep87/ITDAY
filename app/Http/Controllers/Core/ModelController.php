<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Core\Module;

class ModelController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            parent::__construct();
            $this->model = new Module();
            return $next($request);
        });

    }

    public function index()
    {
        $modules = \DB::table('tb_module')->where('module_type','!=','core')->get();
        return view('core.model.index',['modules'=>$modules]);
    }
    public function create(Request $request)
    {
        $tables = $this->getTables();
        return view('core.model.create',['tables'=>$tables]);
    }

    public function postModel(Request $request)
    {
        $rules = array(
            'name'    => "required|alpha|min:2|unique:tb_module,module_name",
        );
        $validator = \Validator::make($request->all(), $rules);    
        if ($validator->passes()) {

            $name   = $request->input('name');
            $title  = ucwords($name);
            $class  = strtolower(trim($name));
            $note   = $request->input('note');
            $table  = $request->input('table');
            $type   = $request->input('type');
            $active = $request->input('active');

            // Menu 
            $menu['access_data'] =  '{"1":"1","2":"1","3":"1"}';
            $menu['module'] = $class;
            $menu['menu_type'] = 'internal';
            $menu['menu_name'] = $title;
            $menu['menu_icons'] = '';
            $menu['position'] = 'sidebar';
            $menu['active'] = $active ? $active : '0';

            \DB::table('tb_menu')->insert($menu);
            // End Menu

            $primary    = $this->findPrimarykey($table);
            $select     = $request->input('sql_select') ? $request->input('sql_select') : '';
            $where      = $request->input('sql_where') ? $request->input('sql_where') : '';
            $group      = $request->input('sql_group') ? $request->input('sql_group') : ''; 
            $order      = $request->input('sql_order') ? $request->input('sql_order') : ''; 

            $columns = \DB::select("SHOW COLUMNS FROM ".$table);
            $select =  " SELECT {$table}.* FROM {$table} ";
            if($primary !='') {
                $where     = " WHERE ".$table.".".$primary." IS NOT NULL";
                $order = " ORDER BY ".$table.".".$primary." ASC";
            } else { 
                $primary = $columns[0]->Field;
                $where  = " WHERE ".$table.".".$primary." IS NOT NULL";
                $order = " ORDER BY ".$table.".".$primary." ASC";
            }
            
            $i = 0; $rowGrid = array();$rowForm = array();
            foreach($columns as $key => $column)
            {
                if(!isset($column->Table)) $column->Table = $table;
                if($column->Key == 'PRI') $column->Type = 'hidden';
                if($column->Table == $table) 
                {                
                    $form_creator = $this->configForm($class, $column->Field,$column->Table,$column->Type,$column->Null,$i);
                    $relation = $this->buildRelation($table ,$column->Field);
                    foreach($relation as $row) 
                    {
                        $array = array('external',$row['table'],$row['column']);
                        $form_creator = $this->configForm($class, $column->Field,$table,'select',$column->Null,$i,$array);
                    }
                    $table_creator = $this->configGrid($class, $column->Field,$column->Table,$column->Type,$i);     

                    $rowForm[] = $form_creator;
                    $rowGrid[] = $table_creator;           
                }
                $i++;
            }
            $config['sql_select']        = $select;
            $config['sql_where']         = $where;
            $config['sql_group']         = $group;
            $config['sql_order']         = $order;
            $config['table_db']          = $table ;
            $config['primary_key']       = $primary;
            $config['grid']              = $rowGrid ;
            $config['forms']             = $rowForm ; 

            $data = array(
                'module_name'       => $class,
                'module_title'      => $title,
                'module_note'       => $note,
                'module_db'         => $table,    
                'module_db_key'     => $primary,
                'module_type'       => $type ? $type : 'addon',
                'module_created'    => date("Y-m-d H:i:s"),
                'module_config'     => \SiteHelpers::CF_encode_json($config),            
            );
            
            \DB::table('tb_module')->insert($data);
            
            // Add default permission
            $tasks = array(
                'is_global'         => 'Global',
                'is_view'           => 'View ',
                'is_detail'         => 'Detail',
                'is_add'            => 'Add ',
                'is_edit'           => 'Edit ',
                'is_remove'         => 'Remove ',
                'is_excel'          => 'Excel ',    
            );                    
            $groups = \DB::table('tb_groups')->get();
            $row = \DB::table('tb_module')->where('module_name',$data['module_name'])->first();        
            if($row)
            {                
                foreach($groups as $group)
                {
                    $permission = array();
                    foreach($tasks as $t=>$v)            
                    {
                        if($group->group_id =='1') {
                            $permission[$t] = '1' ;
                            if($type == 'report' && ($t == 'is_add' || $t == 'is_edit' || $t == 'is_remove')){
                                $permission[$t] = '0';
                            }
                        } else {
                            $permission[$t] = '0' ;
                        }    
                    
                    }        
                    $data = array
                    (
                        "access_data"      => json_encode($permission),
                        "module_id"        => $row->module_name,                
                        "group_id"         => $group->group_id,
                    );
                    \DB::table('tb_groups_access')->insert($data);
                }
                return redirect('core/model/rebuild/'.$row->module_id.'?return='.url('core/model/config/'.$row->module_id.'/info'));        
            } else {
                return redirect('core/module');
            }

            return redirect('core/model')->with(['message'=>'Successfully created.','status'=>'success']);
        }else{
            return redirect('core/model')->with(['message'=>$validator->errors()->first('name'),'status'=>'error'])->withErrors($validator)->withInput();
        }
    }

    public function getExport(Request $request){
        if( count( $ids = $request->input('ids')) < 1){
            return redirect('core/model')->with('message','Can not find module')->with('status','error');   
        };
        $this->data['enc_id'] = implode(",", $ids);
        return view('core.model.export', $this->data);
    }

    public function doexport(Request $request) {
        ini_set('memory_limit', '-1');
        $ids = explode(",", $request->ids);
        $inc_paths = explode(",",str_replace("\r\n", ",", $request->inc_paths));
        $sql_cmd = $request->sql_cmd;
        if($request->file('sql_file')){
            $sql_file = $request->file('sql_file');
            $sql_path     = $sql_file->getrealpath();
            if( $sql_content = file_get_contents( $sql_path ) ){
                $sql_cmd .= $sql_content;
            }
        }

        $cf_zip = new \ZipHelpers;
        $zip_name = date('Y-m-d-his').".zip";
        $zip_file ="./uploads/zip/".$zip_name;
        if(!is_dir("./uploads/zip/")) mkdir("./uploads/zip/");
         
        $_menus = [];
        $_group_access = [];
        $_modules = \DB::table("tb_module")->whereIn('module_id',$ids)->get();
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
        
         
        $cf_zip->add_data( ".setting", base64_encode(serialize($setting))); 

        foreach ( $_modules as $n => $_module ){ 
            $file = strtolower($_module->module_name); 
            $cf_zip->add_data( "app/Http/Controllers/". ucwords($file)."Controller.php", file_get_contents( base_path()."/app/Http/Controllers/". ucwords($file)."Controller.php")) ; 
            $cf_zip->add_data( "app/Http/Controllers/API/". ucwords($file)."APIController.php", file_get_contents( base_path()."/app/Http/Controllers/API/". ucwords($file)."APIController.php")) ; 
            $cf_zip->add_data( "app/Models/". ucwords($file).".php", file_get_contents(base_path()."/app/Models/". ucwords($file).".php")) ;
            $cf_zip->get_files_from_folder( base_path()."/resources/views/{$file}/","resources/views/{$file}/"); 
            $tables[] = $_module->module_db;
        }
        foreach ($inc_paths as $path) {
            $path = trim(preg_replace("/(\r|\n)/", "", $path));
            if(is_dir(base_path($path))) {
                $cf_zip->get_files_from_folder( base_path($path) , $path );
            }elseif(is_file(base_path($path))) {
                $cf_zip->add_data($path, file_get_contents( base_path($path)));
            }
        }

        $sql = $this->backup_table(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'),$tables);
        $sql .= $sql_cmd;
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
        return view('core.model.import');
    }

    public function postImport(){

        $zip_path = $_FILES['installer']['tmp_name'];

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
                
                $this->store_setting($_setting['tb_module'],'tb_module','module_name','module_id'); 
                $this->store_setting($_setting['tb_groups_access'],'tb_groups_access','module_id','id', false); 
                $this->store_setting($_setting['tb_menu'],'tb_menu','menu_name','menu_id');
            }
            $_tmpfile = ['.mysql','.setting']; 
            foreach ( $_tmpfile as $_file ){ 
                @unlink( base_path().'/'. $_file ); 
            }
          
        } else { 
            $data['status'] = 0; 
            $data['error'] = "unzip error";
        }
        self::createRouters();
        return redirect('core/model')->with(['message'=>'Successfully created.','status'=>'success']);
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

    public function destory($id = null, Request $request)
    {
        if($id != null) {
            $ids[] = $id;
        }else{
            $ids = $request->ids;
        }
        
        if(count($ids) > 0)
        {
            foreach ($ids as $id) {
                $row = \DB::table('tb_module')->where('module_id', $id)->first();
                $path = strtolower($row->module_name);    
                $class = $row->module_name;   

                if($row->module_type != 'core')
                {
                    
                    if($class !='') {

                        \DB::table('tb_module')->where('module_id','=',$row->module_id)->delete();
                        \DB::table('tb_groups_access')->where('module_id','=',$row->module_name)->delete();
                        \DB::table('tb_menu')->where('module','=',$row->module_name)->delete();
                        
                        $this->createRouters();          
                        
                        $dirV = base_path().'/resources/views/'.$class;
                        $dirC = app_path().'/Http/Controllers/';
                        $dirAC = app_path().'/Http/Controllers/API/';
                        $dirM = app_path().'/Models/';

                        $class = ucwords($class);
                        
                        @unlink($dirC."/{$class}Controller.php");
                        @unlink($dirAC."/{$class}APIController.php");
                        @unlink($dirM."/{$class}.php");
                           
                        $this->removeDir($dirV);

                    }    
                }
            }
            return redirect('core/model')->with(['message'=>'This model has been removed successfully','status'=>'success']);                
        }

        return redirect('core/model')->with('message', 'The model could not destroyed.!')->with('status','error');
    }

    public function getConfig($id, $view, Request $request)
    {
        $module = \DB::table('tb_module')->where('module_id', $id)->first();
        $config = \SiteHelpers::CF_decode_json($module->module_config);
        $data['row'] = $module;
        $data['config'] = $config;
        $data['formats'] =  [
                                'date'          => 'Date',
                                'image'         => 'Image',
                                'link'          => 'Link',
                                'checkbox'      => 'Checkbox/Radio',
                                'radio'         => 'Radio',
                                'file'          => 'Files',
                                'database'      => 'Database',
                                'limit'         => 'Limit String',                      
                                'number_format' => 'Number Format'                       
                            ];
        // Connection Form
        $data['table_field'] = $request->table_field;
        $data['table_alias'] = $request->table_alias;
        if($request->table_field)
        {
            $conn = [];
            foreach($config['grid'] as $form)
            {
                if($form['field'] == $request->table_field)
                {
                    $conn['db'] = isset($form['conn']['db']) ? $form['conn']['db'] : '';
                    $conn['key'] = isset($form['conn']['key']) ? $form['conn']['key'] : '';
                    $conn['display'] = isset($form['conn']['display']) ? $form['conn']['display'] : '';   
                }    
            }
            $data['conn'] = $conn;
        }
        // End Connection Form
        if($request->form_field)
        {
            $field = [];
            foreach( $config['forms'] as $form )
            {
                if($form['field'] == $request->form_field && $form['alias'] == $request->form_alias)
                {
                    $field = $form;
                }
            }
            $data['field'] = $field;
            $data['field_type_opt'] =[
                                        'text'            => 'Text' ,
                                        'text_tags'       => 'Tags Input' ,
                                        'text_date'       => 'Date',
                                        'text_datetime'   => 'Date & Time',
                                        'textarea'        => 'Textarea',
                                        'textarea_editor' => 'Textarea with Editor ',
                                        'select'          => 'Select Option',
                                        'radio'           => 'Radio' ,
                                        'checkbox'        => 'Checkbox',
                                        'file'            => 'File Upload',            
                                        'hidden'          => 'Hidden',
                                        'auto_val'        => 'Random Value'
                                     ];
        }

        $data['reqType'] =  [
                                'required'          => 'Required',
                                'unique'            => 'Required Unique',
                                'alpa'              => 'Required Only Alpha ',
                                'numeric'           => 'Required Only Number',  
                                'alpa_num'          => 'Required Alpha & Numeric ',         
                                'email'             => 'Required Email',
                                'url'               => 'Required Url',
                                'date'              => 'Required Date',
                            ];
        $tables = [];
        $dbname = 'Tables_in_'.env('DB_DATABASE', 'forge'); 
        $tb_result =  \DB::select("SHOW TABLES FROM ".env('DB_DATABASE', 'forge'));
        foreach ($tb_result as $table) {
            $tables[$table->{$dbname}] = $table->{$dbname};
        }
        $data['tables'] = $tables;
        $data['modules'] = \DB::table('tb_module')->where('module_type','!=','core')->orwhere('module_name','users')->get();

        // Form Design
        $data['title'] = isset($config['form_layout']) ? explode(",",$config['form_layout']['title']) : [$module->module_name];
        $data['format'] = isset($config['form_layout']) ?  $config['form_layout']['format'] : 'grid';    
        $data['display'] = isset($config['form_layout']['display']) ? $config['form_layout']['display']: 'horizontal';        
        $data['form_column'] = (isset($config['form_column']) ? $config['form_column'] : 1 );
        $data['form_width'] = (isset($config['form_width']) ? $config['form_width'] : '6^6' );
        if($request->input('block')) $data['form_column'] = $request->input('block');
        if($request->input('width')) $data['form_width'] =  $request->input('width');
        // End Form Design

        // Relation Form
        $config['subgrid'] = (isset($config['subgrid']) ? $config['subgrid'] : array());
        $data['config'] = $config;
        // End Relation Form

        // Permission
        if(!isset($config['tasks'])){
            $config['tasks'] = [
                                'is_global'   => 'Global ',
                                'is_view'     => 'View ',
                                'is_detail'   => 'Detail',
                                'is_add'      => 'Add ',
                                'is_edit'     => 'Edit ',
                                'is_remove'   => 'Remove ',
                                'is_excel'    => 'Excel ',            
                            ];
            $data['config'] = $config;
        }else{
            foreach($config['tasks'] as $row)
            {
                $config['tasks'][$row['item']] = $row['title'];
            }
            $data['config'] = $config;
        }
        $groups = \DB::table('tb_groups')->get();
        $access = [];
        foreach($groups as $group)        
        {
            $rows = [];
            $groupAccess = \DB::table('tb_groups_access')->where('group_id', $group->group_id)->where('module_id', $module->module_name)->first();
            $access_data = (isset($groupAccess->access_data) ? json_decode($groupAccess->access_data,true) : array());
            $rows['group_id'] = $group->group_id;
            $rows['group_name'] = $group->name;
            foreach($config['tasks'] as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access[$group->name] = $rows;
        }
        $data['access'] = $access;
        // End Permission

        // Notification
        $email_tpl = file_get_contents(base_path()."/resources/views/core/template/email.tpl");
        $email = ['body'=>$email_tpl];
        $config['email'] = isset($config['email']) ? $config['email'] : $email;
        $data['config'] = $config;
        return view("core.model.config.{$view}",$data);
    }

    public function postInfo($id, Request $request)
    {
        $rules = array(
            'module_title'=>'required'
        );    
        $validator = \Validator::make($request->all(), $rules);    
        if ($validator->passes()) {
            $data = array(
                'module_title'      => $request->input('module_title'),
                'module_note'       => $request->input('module_note'),
            );

            \DB::table('tb_module')->where('module_id', '=',$id )->update($data);
            return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/info'));
        } else {
            return redirect('core/model/config/'.$id.'/info')
            ->with('message','The following errors occurred')->with('status','error')
            ->withErrors($validator)->withInput();
        }        
    }

    public function postSql($id, Request $request)
    {
        $rules = array(
            'sql_select'=>'required',
            'sql_where'=>'required'
        );    
        $validator = \Validator::make($request->all(), $rules);    
        if ($validator->passes()) {
            $select     = $request->input('sql_select');
            $where     = $request->input('sql_where');
            $group     = $request->input('sql_group');
            $order     = $request->input('sql_order');
            try {   
                \DB::select( $select .' '.$where.' '.$group.' '.$order );            
                
            }catch(Exception $e){
                // Do something when query fails. 
                $error ='Error : '.$select .' '.$where.' '.$group ;
                return redirect('core/model/config/'.$id.'/sql')
                ->with('message', $error)->with('status','error');   
            }

            $row = \DB::table('tb_module')->where('module_id', $id)->first();
            $config = \SiteHelpers::CF_decode_json($row->module_config); 
            $columns = Module::getColoumnInfo($select .' '.$where.' '.$group);
            $i =0;$form =array(); $grid = array();
            foreach($columns as $field)
            {
                $name = $field['name'];
                $alias = $field['table'];
                $grids =  $this->configGrid($row->module_name, $name , $alias , '' ,$i);
                foreach($config['grid'] as $g) 
                {
                    if(!isset($g['type'])) $g['type'] = 'text';
                    if($g['field'] == $name && $g['alias'] == $alias) 
                    {
                        $grids = $g;                
                    } 
                }
                
                $grid[] = $grids ;
                if($row->module_db == $alias ) 
                {
                    $forms = $this->configForm($row->module_name, $name,$alias,'text','NULL',$i);
                    foreach($config['forms'] as $f)
                    {
                        if($f['field'] == $name && $f['alias'] == $alias) 
                        {                            
                            $forms = $f;                            
                        }
                    }                
                    $form[] = $forms ;
                }    
                $i++;    
            }

            $config["forms"]      = $form;
            $config["grid"]       = $grid;
            $config["sql_select"] = $select;
            $config["sql_group"]  = $group;
            $config["sql_order"]  = $order;
            $config["sql_where"]  = $where; 

            \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));  
            return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/sql'));
        } else {
            return redirect('core/model/config/'.$id.'/sql')
            ->with('message','The following errors occurred')->with('status','error')
            ->withErrors($validator)->withInput();
        }        
    }

    public function postTable($id, Request $request)
    {
        
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        if($row){     
            $config = \SiteHelpers::CF_decode_json($row->module_config); 
            $grid   = [];
            $total  = count($request->field);
            for($i=1; $i<= $total ;$i++) {    
                $grid[] = [
                    'class'         => $row->module_name,
                    'field'         => $request->field[$i],
                    'alias'         => $request->alias[$i],
                    'language'      => ['en'],
                    'label'         => $request->label[$i],
                    'view'          => isset($request->view[$i]) ? 1 : 0 ,
                    'detail'        => isset($request->detail[$i]) ? 1 : 0 ,
                    'sortable'      => isset($request->sortable[$i]) ? 1 : 0 ,
                    'search'        => isset($request->search[$i]) ? 1 : 0 ,
                    'download'      => isset($request->download[$i]) ? 1 : 0 ,
                    'api'           => isset($request->api[$i]) ? 1 : 0 ,
                    'frozen'        => isset($request->frozen[$i]) ? 1 : 0 ,
                    'limited'       => $request->limited[$i] ? $limited[$i] : '',
                    'width'         => $request->width[$i],
                    'align'         => $request->align[$i],
                    'sortlist'      => $request->sortlist[$i],
                    'conn'          =>  [
                                            'valid'     => $request->conn_valid[$i],
                                            'db'        => $request->conn_db[$i],
                                            'key'       => $request->conn_key[$i],
                                            'display'   => $request->conn_display[$i]
                                        ],
                    'format_as'     => $request->format_as[$i] ? $request->format_as[$i] : '',
                    'format_value'  => $request->format_value[$i] ? $request->format_value[$i] : ''                   
                ];
            }

            $config["grid"] = $grid;
            
            \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
            return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/table'));         
        }                           
    }

    public function postConn($id, Request $request)
    {     
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        if($row)
        {
            $grid = [];
            $config = \SiteHelpers::CF_decode_json($row->module_config); 
            foreach($config['grid'] as $form)
            {
                if($form['field'] == $request->table_field && $form['alias'] == $request->table_alias )
                {
                    if($request->db != '')
                    {                    
                        $value = implode("|",$request->display);
                        $form['conn'] = array(
                                            'valid'         => '1',
                                            'db'            => $request->input('db'),
                                            'key'           => $request->input('key'),
                                            'display'       => implode("|",array_filter($request->display)),
                                        );                        
                    } else {
                        $form['conn'] = array(
                                            'valid'      => '0',
                                            'db'         => '',
                                            'key'        => '',
                                            'display'    => '',
                                        );    

                    }
                    $grid[] =  $form;    
                } else {
                    $grid[] =  $form;
                }
            }    
            $config["grid"] = $grid;

            \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
            return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/table'));            
        }
    }

    public function postForm($id, Request $request)
    {
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        if($row)
        { 
            $config = \SiteHelpers::CF_decode_json($row->module_config); 
            $input = $request->all();
            foreach ($input['sortlist'] as $i => $value) {
                $config['forms'][$i]['class'] = $row->module_name;
                $config['forms'][$i]['limited'] = isset($input['limited'][$i]) ? $input['limited'][$i] : '';
                $config['forms'][$i]['label'] = $input['label'][$i];
                $config['forms'][$i]['view'] = isset($input['view'][$i]) ? 1 : 0;
                $config['forms'][$i]['search'] = isset($input['search'][$i]) ? 1 : 0;
                $config['forms'][$i]['required'] = isset($input['required'][$i]) ? $input['required'][$i] : 0;
                $config['forms'][$i]['sortlist'] = $value;
            }
           
            \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
            return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/form')); 
        }               
    }

    public function postFormField($id, Request $request)
    {
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        if($row)
        {
            $config = \SiteHelpers::CF_decode_json($row->module_config);   
            $lookup_value = (is_array($request->input('lookup_value')) ? implode("|",array_filter($request->input('lookup_value'))) : '');
            if(preg_match('/(select|radio|checkbox)/',$request->input('type'))) 
            {
                if($request->input('opt_type') == 'datalist')
                {
                    $datalist = '';
                    $cf_val     = $request->input('custom_field_val');
                    $cf_display = $request->input('custom_field_display');
                    for($i=0; $i<count($cf_val);$i++)
                    {
                        $value         = $cf_val[$i];
                        if(isset($cf_display[$i])) { $display = $cf_display[$i]; } else { $display ='none';}
                        $datalist .= $value.':'.$display.'|';
                    }
                    $datalist = substr($datalist,0,strlen($datalist)-1);
                
                } else {
                    $datalist = ''; 
                }
            }  else {
                $datalist = '';
            }

            foreach($config['forms'] as $key => $form)
            {
                if($form['field'] == $request->input('field') && $form['alias'] == $request->input('alias') ) 
                {
                    $form['option']['opt_type'] = $request->input('opt_type');
                    $form['option']['lookup_query'] = $datalist;
                    $form['option']['lookup_table'] = $request->input('lookup_table');
                    $form['option']['lookup_key'] = $request->input('lookup_key');
                    $form['option']['lookup_value'] = $lookup_value;
                    $form['option']['is_dependency'] = $request->input('is_dependency') ? 1 : 0;
                    $form['option']['lookup_dependency_key'] = $request->input('lookup_dependency_key');
                    $form['option']['select_multiple'] = (!is_null($request->input('select_multiple')) ? '1':'0');
                    $form['option']['image_multiple'] = (!is_null($request->input('image_multiple')) ? '1':'0');
                    $form['option']['save_full_path'] = (!is_null($request->input('save_full_path')) ? '1':'0');
                    $form['option']['save_original_image'] = (!is_null($request->input('save_original_image')) ? '1':'0');
                    $form['option']['path_to_upload'] = $request->input('path_to_upload');
                    $form['option']['sub_foldername'] = $request->input('sub_foldername');
                    $form['option']['upload_type'] = $request->input('upload_type');
                    $form['option']['resize_width'] = $request->input('resize_width');
                    $form['option']['resize_height'] = $request->input('resize_height');
                    $form['option']['quality'] = $request->input('quality') > 100 ? 100 : $request->input('quality');
                    $form['option']['tooltip'] = $request->input('tooltip');
                    $form['option']['helptext'] = $request->input('helptext');
                    $form['option']['placeholder'] = $request->input('placeholder');
                    $form['option']['attribute'] = $request->input('attribute');
                    $form['option']['extend_class'] = $request->input('extend_class');
                    $form['option']['prefix'] = $request->input('prefix');
                    $form['option']['sufix'] = $request->input('sufix');
                    $form['option']['str_prefix'] = $request->input('str_prefix');
                    $form['option']['val_type'] = (!is_null($request->input('val_type')) && $request->input('val_type') == 'str' ? 'str':'num');
                    $config['forms'][$key] = $form;
                    $config['forms'][$key]['type'] = $request->input('type');
                }
            }

            \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
            return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/form'));
        }
    }

    public function postSubForm($id, Request $request)
    {
        $rules = array(
            'title'           =>'required',
            'master'           =>'required',
            'master_key'      =>'required',
            'module'          =>'required',
            'primary_key'      =>'required',
            'key'              =>'required',
        );  
        $validator = \Validator::make($request->all(), $rules);    
        if ($validator->passes()) {                

            $row = \DB::table('tb_module')->where('module_id', $id)->first();
            $config = \SiteHelpers::CF_decode_json($row->module_config); 

            $subform = array(
                'title'          => $request->get('title'),
                'master'         => $request->get('master'),
                'master_key'     => $request->get('master_key'),
                'module'         => $request->get('module'),
                'table'          => $request->get('table'),
                'primary_key'    => $request->get('primary_key'),
                'key'            => $request->get('key'),
            );
             
            $config['subform'] = $subform; 
            \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
            return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/subform'));

        }  else {
            dd($validator);
            return redirect('core/model/config/'.$id.'/subform')
            ->with('message', 'The following errors occurred')->with('status','error')
            ->withErrors($validator)->withInput();
        }            
    }

    public function removeSubForm($id)
    {
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        $config = \SiteHelpers::CF_decode_json($row->module_config); 
        
        unset($config["subform"]);

        \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
        return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/subform'));
    }

    public function postFormDesign($id, Request $request)
    {
        $row = \DB::table('tb_module')->where('module_id', $id)->first();  
        $config = \SiteHelpers::CF_decode_json($row->module_config); 
        $data = $request->reordering;
        $data = json_decode($data);
        $currForm = $config['forms'];
        foreach($currForm as $f)
        {
            $cform[$f['field']] = $f;     
        }    
    
        $i = 0; $order = 0; $f = array();
        foreach($data as $dat)
        { 
            $forms = $dat;
            foreach($forms as $form)
            {
                if(isset($cform[$form->id]))
                {
                    $cform[$form->id]['form_group'] = $i;
                    $cform[$form->id]['sortlist'] = $order;
                    $cform[$form->id]['input_group'] = [];
                    foreach ($form->children as $group) {
                        foreach ($group as $input) {
                            $cform[$form->id]['input_group'][] = \SiteHelpers::CF_decode_json($input->val);
                        }
                    }
                    $f[] = $cform[$form->id];
                }else{
                    $cform[$form->id] = \SiteHelpers::CF_decode_json($form->val);
                    $cform[$form->id]['form_group'] = $i;
                    $cform[$form->id]['sortlist'] = $order;
                    $cform[$form->id]['input_group'] = [];
                    foreach ($form->children as $group) {
                        foreach ($group as $input) {
                            $cform[$form->id]['input_group'][] = \SiteHelpers::CF_decode_json($input->val);
                        }
                    }
                    $f[] = $cform[$form->id];
                }
                $order++;
            }
            $i++;
            
        }
  
        $config['form_column'] = count($data);
        $config['form_width'] = $request->input('width') ? $request->input('width') : '6^6';
        $config['form_layout'] = array(
            'column'    => count($data),
            'width'    => explode('^', $config['form_width']),
            'title' => implode(',',$request->input('title')) ,
            'format' => $request->input('format'),
            'display' => $request->input('display')
            
        );
        
        $config["forms"] = $f;
        
        \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
        return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/formdesign'));
    }

    public function postRelation($id, Request $request)
    {
        $rules = array(
            'title'           =>'required',
            'relation'        =>'required',
            'master'          =>'required',
            'master_key'      =>'required',
            'module'          =>'required',
            'key'             =>'required',
        );    
        $validator = \Validator::make($request->all(), $rules);    
        if ($validator->passes()) {

            $row = \DB::table('tb_module')->where('module_id', $id)->first(); 
            $config = \SiteHelpers::CF_decode_json($row->module_config); 

            $data[] = array(
                'title'         => $request->get('title'), 
                'relation'      => $request->get('relation'),
                'master'        => $request->get('master'),
                'master_key'    => $request->get('master_key'),
                'module'        => $request->get('module'),
                'table'         => $request->get('table'),
                'key'           => $request->get('key'),
            );
            
            $subgrid = [];
            if(isset($config["subgrid"]))
            {
                foreach($config['subgrid'] as $sb)
                {
                    $subgrid[] =$sb;
                }    
                
            }
            $subgrid = array_merge($subgrid,$data);
            $config['subgrid'] = $subgrid;         
            
            \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
            return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/relation'));

        }  else {
            return redirect('core/model/config/'.$id.'/relation')
            ->with('message', 'The following errors occurred')->with('status','error')
            ->withErrors($validator)->withInput();
        }
    }

    public function removeRelation($id, Request $request)
    {
        $module = $request->input('module');
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        $config = \SiteHelpers::CF_decode_json($row->module_config);
        $subgrid = array();

        foreach($config['subgrid'] as $sb)
        {
            if($sb['module'] != $module) {
                $subgrid[] = $sb;
            }    
        }
        
        $config["subgrid"] = $subgrid;

        \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
        return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/relation')); 
    }

    public function postPermission($id, Request $request)
    {
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        $config = \SiteHelpers::CF_decode_json($row->module_config); 
        $tasks = array(
            'is_global'    => 'Global',
            'is_view'      => 'View',
            'is_detail'    => 'Detail',
            'is_add'       => 'Add',
            'is_edit'      => 'Edit',
            'is_remove'    => 'Remove',
            'is_excel'     => 'Excel',            
        );    
      
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row)
            {
                $tasks[$row['item']] = $row['title'];
            }
        }    
        
        $permission = array();
        $group_id = $request->input('group_id');
        for($i=0;$i<count($group_id); $i++) 
        {
            // remove current group_access             
            $gid = $group_id[$i];
            \DB::table('tb_groups_access')->where('module_id','=',$row->module_name)->where('group_id','=',$gid)->delete();    
            $permissions = [];
            foreach($tasks as $t=>$v)            
            {
                $permissions[$t] = (isset($_POST[$t][$gid]) ? "1" : "0" );
            }
            $data = [
                        "access_data"    => json_encode($permissions),
                        "module_id"      => $row->module_name,                
                        "group_id"       => $group_id[$i],
                    ];
            \DB::table('tb_groups_access')->insert($data);    
        }
        return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/permission'));   
    }

    public function postEmail($id, Request $request)
    {
        $rules = array(
            'to'           =>'required',
            'subject'        =>'required',
            'body'          =>'required',
        );
        $validator = \Validator::make($request->all(), $rules);    
        if ($validator->passes()) {

            $row = \DB::table('tb_module')->where('module_id', $id)->first(); 
            $config = \SiteHelpers::CF_decode_json($row->module_config); 

            $config['email'] = array(
                                    'to'            => $request->get('to'), 
                                    'cc'            => $request->get('cc'),
                                    'subject'       => $request->get('subject'),
                                    'body'          => $request->get('body'),
                                );

            file_put_contents(base_path()."/resources/views/emails/".strtolower($row->module_name).".blade.php", $config['email']['body']);
            \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
            return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/email'));

        }  else {
            return redirect('core/model/config/'.$id.'/email')
            ->with('message', 'The following errors occurred')->with('status','error')
            ->withErrors($validator)->withInput();
        }
    }

    public function removeEmail($id)
    {
        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        $config = \SiteHelpers::CF_decode_json($row->module_config); 
        
        unset($config["email"]);

        \DB::table('tb_module')->where('module_id',$id)->update(array('module_config' => \SiteHelpers::CF_encode_json($config)));        
        return redirect('core/model/rebuild/'.$id.'?return='.url('core/model/config/'.$id.'/email'));
    }

    public function getRebuild(Request $request, $id = 0)
    {

        $row = \DB::table('tb_module')->where('module_id', $id)->first();
        if(!$row){
            return redirect('core/model/create')->with(['message','Can not find module.','status'=>'error']);      
        }   
        $this->builder($row, $request);
        if($request->ajax() == true && \Auth::check() == true)
        {
            return response()->json(array(['status'=>'success','message'=>'Script has been replaced successfully.'])); 
        } else {
            $returnUrl = $request->input('return') != null ? $request->input('return') : url()->previous();
            return redirect($returnUrl)->with(['message'=>'The script has been changed successfully.','status'=>'success','rebuild'=>true]);   
        }
    }

    public function postRebuild(Request $request)
    {
        foreach ($request->ids as $id) {
            $row = \DB::table('tb_module')->where('module_id', $id)->first();
            if($row){
                $this->builder($row, $request);      
            }
        }

        if($request->ajax() == true && \Auth::check() == true)
        {
            return response()->json(array(['status'=>'success','message'=>'Script has been replaced successfully.'])); 
        } else {
            $returnUrl = $request->input('return') != null ? $request->input('return') : url()->previous();
            return redirect($returnUrl)->with(['message'=>'The script has been changed successfully.','status'=>'success','rebuild'=>true]);   
        }
    }

    function builder($row, $request = null)
    {
        $config         = \SiteHelpers::CF_decode_json($row->module_config); 
        $class          = strtolower($row->module_name);
        $ctr            = ucwords($row->module_name);
        $path           = strtolower($row->module_name);
        $module_table   = $row->module_db;

        $columns = \DB::select("SHOW FULL COLUMNS FROM `$module_table`");
        foreach ($columns as $key => $col) {
            $formconfig = $this->getFormConfig($class, $module_table, $col, $config['forms'], $key);
            if($formconfig)
                $forms[] = $formconfig;
            $grids[] = $this->getGridConfig($class, $module_table, $col, $config['grid'], $key);
        }
        usort($forms,"\SiteHelpers::_sort"); 
        usort($grids,"\SiteHelpers::_sort");
        $config['forms'] =  $forms;
        $config['grid'] = $grids;
        \DB::table('tb_module')->where('module_id', '=',$row->module_id )
            ->update(array('module_config' => \SiteHelpers::CF_encode_json($config))); 
        if($row->module_type != 'core')
        {
            // build Field entry 
            $f = '';
            $req = '';
        
            // End Build Field Entry
            $codes = array(
                'domain'            => env('APP_URL'),
                'controller'        => ucwords(str_replace(' ', '', $row->module_name)),
                'model'             => ucwords($class),
                'class'             => $class,
                'fields'            => $f,
                'required'          => $req,
                'table'             => $row->module_db ,
                'title'             => $row->module_title ,
                'note'              => $row->module_note ,
                'key'               => $row->module_db_key,
                'sql_select'        => $config['sql_select'],
                'sql_where'         => $config['sql_where'],
                'sql_group'         => $config['sql_group'],
                'sql_order'         => (isset($config['sql_order']) ? $config['sql_order'] : ' '),
                'page'              => (isset($config['request']) ? $config['request']['page'] : '1'),
                'rows'              => (isset($config['request']) ? $config['request']['rows'] : '10'),
                'sort'              => (isset($config['request']) ? $config['request']['sort'] : 'id'),
                'order'             => (isset($config['request']) ? $config['request']['order'] : 'asc'),
                'search'            => (isset($config['request']) ? $config['request']['search'] : ''),
                'relations'         => '',
                'master_detail'     => '',
                'join'              => '',
                'icon'              => '',
                'email'             => '',
            );                                        
            if(!isset($config['form_layout'])) 
                $config['form_layout'] = array('column'=>1,'title'=>$row->module_title,'format'=>'grid','display'=>'horizontal');

            if(isset($config['email']))
            {   
                $codes['email'] = '
                $row = $this->model->getRow($id);
                $data = \SiteHelpers::formatAPI($row, $this->info["config"]);
                $to = "'.$config['email']['to'].'";
                $cc = "'.$config['email']['cc'].'";
                $subject = "'.$config['email']['subject'].'";
                \Mail::send("emails.'.strtolower($row->module_name).'", ["data"=>$data], function ($message) use($to,$cc,$subject) {
                    if(strlen($cc) > 0)
                        $message->to($to)->cc($cc)->subject($subject);
                    else
                        $message->to($to)->subject($subject);
                });';
            }
                
            $codes['form_javascript'] = \SiteHelpers::toJavascript($config['forms'],$path,$class);
            $codes['form_entry'] = \SiteHelpers::toForm($config['forms'],$config['form_layout']);
            $codes['form_display'] = (isset($config['form_layout']['display']) ? $config['form_layout']['display'] : 'horizontal');
            $codes['form_view'] = \SiteHelpers::toView($config['grid']);

            $codes['masterdetailmodel']     = '';
            $codes['masterdetailinfo']      = '';
            $codes['masterdetailgrid']      = '';
            $codes['masterdetailsave']      = '';
            $codes['masterdetailapisave']   = '';
            $codes['masterdetailform']      = '';
            $codes['masterdetailsubform']   = '';
            $codes['masterdetailview']      = '';
            $codes['masterdetailjs']        = '';
            $codes['masterdetaildelete']    = '';
            $codes['subform']               = '';

            $menu = \DB::table('tb_menu')->where('module',$row->module_name)->first();
            if($menu){
                $codes['icon'] = '<i class="'.$menu->menu_icons.' font-red"></i>';
            }

            /* Subform */
            if(isset($config['subform']))
            {
                $md = \SiteHelpers::toMasterDetail($config['subform']);    
                $codes['masterdetailmodel']     = $md['masterdetailmodel'] ; 
                $codes['masterdetailinfo']      = $md['masterdetailinfo'] ;   
                $codes['masterdetailsave']      = $md['masterdetailsave'] ;
                $codes['masterdetailapisave']   = $md['masterdetailapisave'] ;
                $codes['masterdetailsubform']   = $md['masterdetailsubform'] ;  
                $codes['masterdetailform']      = $md['masterdetailform'] ;                
                $codes['masterdetaildelete']    = $md['masterdetaildelete'];   
                $codes['masterdetailjs']        = $md['masterdetailjs'] ;
                $codes['subform']               = "@include('".$class.".masterdetail')";
            }

            /* End Master Detail */
            $dirV = base_path().'/resources/views/'.$class;
            $dirC = app_path().'/Http/Controllers/';
            $dirAC = app_path().'/Http/Controllers/API/';
            $dirM = app_path().'/Models/';
            
            if(!is_dir($dirV)) mkdir( $dirV,0777 );
            if(!is_dir($dirAC)) mkdir( $dirAC,0777 );
            if(!is_dir($dirM)) mkdir( $dirM,0777 );

            if($row->module_type =='addon')
            {
                $template = base_path().'/resources/views/core/template/';
                $controller = file_get_contents(  $template.'controller.tpl' );
                $api_controller = file_get_contents(  $template.'api_controller.tpl' );
                $grid = file_get_contents(  $template.'grid.tpl' );               
                $view = file_get_contents(  $template.'view.tpl' );
                $form = file_get_contents(  $template.'form.tpl' );
                $model = file_get_contents(  $template.'model.tpl' );

                if(isset($config['subgrid']) && count($config['subgrid'])>=1)
                {
                    $build_master_detail = '';
                    $view = file_get_contents(  $template.'view_detail.tpl' );
                    foreach ($config['subgrid'] as $key => $sub) {
                        $build_master_detail .= "$('#".str_replace(" ","_",$sub['title'])."').load('{{url(\"admin/".$sub['master']."/lookup/".str_replace(" ","_",implode("-",$sub))."-\".\$row->".$sub['master_key'].")}}');\t\n";
                        $codes['master_detail'] = $build_master_detail;
                    }
                }else{
                    $view = file_get_contents(  $template.'view.tpl' );
                }
        
                $build_controller       = \SiteHelpers::blend($controller,$codes);    
                $build_api_controller   = \SiteHelpers::blend($api_controller,$codes);    
                $build_view             = \SiteHelpers::blend($view,$codes);    
                $build_form             = \SiteHelpers::blend($form,$codes);    
                $build_grid             = \SiteHelpers::blend($grid,$codes);    
                $build_model            = \SiteHelpers::blend($model,$codes);   
                $build_fields           = \SiteHelpers::toForm($config['forms'],$config['form_layout']); 
                $build_master_detail    = $codes['masterdetailform'];         

                if($request != null && !is_null($request->input('rebuild')))
                {
                    // rebuild spesific files
                    if($request->input('c') =='y'){
                        file_put_contents( $dirC."{$ctr}Controller.php" , $build_controller) ;
                        file_put_contents( $dirAC."{$ctr}APIController.php" , $build_api_controller) ;    
                    }
                    if($request->input('m') =='y'){
                        file_put_contents(  $dirM."{$ctr}.php" , $build_model) ;
                    }    
                    
                    if($request->input('g') =='y'){
                        file_put_contents(  $dirV."/index.blade.php" , $build_grid) ;
                    }    
                    if($row->module_db_key !='')
                    {            
                        if($request->input('f') =='y'){
                            file_put_contents(  $dirV."/form.blade.php" , $build_form) ;
                            file_put_contents(  $dirV."/fields.blade.php" , $build_fields);

                            if(isset($config['subform'])){
                                file_put_contents(  $dirV."/masterdetail.blade.php" , $build_master_detail); 
                            }
                        }    

                        if($request->input('v') =='y'){
                            file_put_contents(  $dirV."/view.blade.php" , $build_view) ;
                                                         
                        }
                    }  
                
                } else {
                
                    file_put_contents(  $dirC ."{$ctr}Controller.php" , $build_controller) ;    
                    file_put_contents(  $dirAC ."{$ctr}APIController.php" , $build_api_controller) ;    
                    file_put_contents(  $dirM ."{$ctr}.php" , $build_model) ;
                    file_put_contents(  $dirV."/index.blade.php" , $build_grid) ; 
                    file_put_contents(  $dirV."/form.blade.php" , $build_form) ;
                    file_put_contents(  $dirV."/fields.blade.php" , $build_fields);
                    file_put_contents(  $dirV."/view.blade.php" , $build_view) ;   

                    if(isset($config['subform'])){
                        file_put_contents(  $dirV."/masterdetail.blade.php" , $build_master_detail); 
                    }    
                }
            } 

            if($row->module_type =='report')
            {
                $template = base_path().'/resources/views/core/template/';
                $controller = file_get_contents(  $template.'controller.tpl' );
                $api_controller = file_get_contents(  $template.'api_controller.tpl' );
                $grid = file_get_contents(  $template.'report.tpl');
                $view = file_get_contents(  $template.'view.tpl' );
                $model = file_get_contents(  $template.'model.tpl' );

                if(isset($config['subgrid']) && count($config['subgrid'])>=1)
                {
                    $build_master_detail = '';
                    $view = file_get_contents(  $template.'view_detail.tpl' );
                    foreach ($config['subgrid'] as $key => $sub) {
                        $build_master_detail .= "$('#".str_replace(" ","_",$sub['title'])."').load('{{url(\"admin/".$sub['master']."/lookup/".str_replace(" ","_",implode("-",$sub))."-\".\$row->".$sub['master_key'].")}}');\t\n";
                        $codes['master_detail'] = $build_master_detail;
                    }
                }
        
                $build_controller       = \SiteHelpers::blend($controller,$codes);
                $build_api_controller   = \SiteHelpers::blend($api_controller,$codes);
                $build_view             = \SiteHelpers::blend($view,$codes);
                $build_grid             = \SiteHelpers::blend($grid,$codes);
                $build_model            = \SiteHelpers::blend($model,$codes);
                $build_fields           = \SiteHelpers::toForm($config['forms'],$config['form_layout']); 

                file_put_contents(  $dirC ."{$ctr}Controller.php",$build_controller) ;    
                file_put_contents(  $dirAC ."{$ctr}APIController.php",$build_api_controller) ;    
                file_put_contents(  $dirM ."{$ctr}.php",$build_model);
                file_put_contents(  $dirV."/index.blade.php",$build_grid);
                file_put_contents(  $dirV."/fields.blade.php",$build_fields); 
                file_put_contents(  $dirV."/view.blade.php" , $build_view);

                if(isset($config['subform'])){
                    file_put_contents(  $dirV."/masterdetail.blade.php" , $build_master_detail); 
                }  
            }
            self::createRouters();
        }
    }

    function createRouters()
    {
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
        unset($tables['tb_password_resets']);
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

    public function getFormConfig($class, $table, $column, $forms, $sort){
        // return the field already existing in config;
        foreach ($forms as $key => $form) {
            if($form['field'] == $column->Field){
                return $form;
            }elseif(isset($form['input_group'])){
                // If it already existing in input group, skip this field;
                foreach ($form['input_group'] as $input) {
                    if($input['field'] == $column->Field){
                        return 0;
                    }
                }
            }
            
        }

        // else return new field config;
        $form_creator = self::configForm($class, $column->Field,$table,$column->Type,$column->Null,$sort);
        $relation = self::buildRelation($table ,$column->Field);
        foreach($relation as $row) 
        {
            $array = array('external',$row['table'],$row['column']);
            $form_creator = self::configForm($class, $column->Field,$table,'select',$column->Null,$i,$array);
            
        }

        return $form_creator;
    }   

    public function getGridConfig($class, $table, $column, $grids, $sort){
        // return existing field config;
        foreach ($grids as $key => $grid) {
            if($grid['field'] == $column->Field){
                return $grid;
            }
        }

        // else return new field config;
        return self::configGrid($class, $column->Field,$table,$column->Type,$sort);
    }

    function configForm($class, $field , $alias, $type , $null, $sort, $opt = array()) {
        
        $opt_type = ''; $lookup_table =''; $lookup_key ='';
        if(count($opt) >=1) {
            $opt_type = $opt[0]; $lookup_table = $opt[1]; $lookup_key = $opt[2];
        }
    
        $forms = array(
            "class"         => $class,
            "field"         => $field,
            "alias"         => $alias,
            "label"         => ucwords(str_replace('_',' ',$field)),
            "language"      => array(),
            'required'      => $type != 'hidden' && $null == 'NO' ? 'required' : '0',
            'view'          => $field == 'created_at' || $field == 'updated_at' ? '0' : '1',
            'type'          => self::configFieldType($type),
            'add'           => '1',
            'edit'          => '1',
            'search'        => '1',
            'size'          => 'span12',
            "sortlist"      => $sort ,
            'form_group'    => '',
            'input_group'   => [],
            'option'        => array(
                "opt_type"                  => $opt_type,
                "lookup_query"              => '',
                "lookup_table"              => $lookup_table,
                "lookup_key"                => $lookup_key,
                "lookup_value"              => $lookup_key,
                'is_dependency'             => '',
                'select_multiple'           => '0',
                'image_multiple'            => '0',
                'save_full_path'            => '0',
                'save_original_image'       => '0',
                'lookup_dependency_key'     => '',
                'path_to_upload'            => '',
                'sub_foldername'            => '',
                'upload_type'               => '',
                'tooltip'                   => '',
                'helptext'                  => '',
                'placeholder'               => '',
                'attribute'                 => '',
                'extend_class'              => '',
                'prefix'                    => '',
                'sufix'                     => '',
                'str_prefix'                => '',
                'val_type'                  => 'str',
                )
            );
        return $forms;    
    
    } 

    function buildRelation( $table , $field)
    {
        $pdo = \DB::getPdo();
        $sql = "
        SELECT
            referenced_table_name AS 'table',
            referenced_column_name AS 'column'
        FROM
            information_schema.key_column_usage
        WHERE
            referenced_table_name IS NOT NULL
            AND table_schema = '".env('DB_DATABASE', 'forge')."'  AND table_name = '{$table}' AND column_name = '{$field}' ";
        $Q = $pdo->query($sql);
        $rows = array();
        while ($row =  $Q->fetch()) {
            $rows[] = $row;
        } 
        return $rows;
    } 

    function configGrid ($class, $field , $alias , $type, $sort ) {
        $grid = array ( 
            "class"         => $class,
            "field"         => $field,
            "alias"         => $alias,
            "label"         => ucwords(str_replace('_',' ',$field)),
            "language"      => array(),
            "search"        => '1' ,
            "download"      => '1' ,
            "api"           => '1' ,
            "align"         => 'left' ,
            "view"          => '1' ,
            "detail"        => '1',
            "sortable"      => '1',
            "frozen"        => '0',
            'hidden'        => '0',            
            "sortlist"      => $sort ,
            "width"         => 'auto',
            "conn"          => array('valid'=>'0','db'=>'','key'=>'','display'=>''),
            "format_as"     =>'',
            "format_value"  =>'',
        );     
        return $grid;
    }

    function configFieldType( $type )
    {
        switch($type)
        {
            default: $type = 'text'; break;
            case 'timestamp'; $type = 'text_datetime'; break;
            case 'datetime'; $type = 'text_datetime'; break;
            case 'string'; $type = 'text'; break;
            case 'int'; $type = 'text'; break;
            case 'text'; $type = 'textarea'; break;
            case 'blob'; $type = 'textarea'; break;
            case 'select'; $type = 'select'; break;
            case 'hidden'; $type = 'hidden'; break;
        }
        return $type;
    
    }  

    function removeDir($dir) {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file))
                self::removeDir($file);
            else
                @unlink($file);
        }
        if(is_dir($dir)) rmdir($dir);
    }       
}
