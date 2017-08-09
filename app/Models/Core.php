<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Core extends Model {


	public static function getRows( $args )
	{
       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;
	   
        extract( array_merge( array(
			'page' 		=> '0' ,
			'limit'  	=> '0' ,
			'sort' 		=> '' ,
			'order' 	=> '' ,
			'params' 	=> '' ,
			'global'	=> 1	  
        ), $args ));
		
		$offset = ($page-1) * $limit ;	
		$limitConditional = ($page !=0 && $limit !=0) ? "LIMIT  $offset , $limit" : '';	
		$orderConditional = ($sort !='' && $order !='') ?  " ORDER BY {$sort} {$order} " : self::queryOrder();

		// Update permission global / own access new ver 1.1
		$table = with(new static)->table;
		if($global == 0 )
				$params .= " AND {$table}.entry_by ='".\Auth::user()->id."'"; 	
		// End Update permission global / own access new ver 1.1			
        
		$rows = array();
	    $result = \DB::select( self::querySelect() . self::queryWhere(). " 
				{$params} ". self::queryGroup() ." {$orderConditional}  {$limitConditional} ");
		
		if($key =='' ) { $key ='*'; } else { $key = $table.".".$key ; }	
		$total = \DB::select( "SELECT COUNT(*) FROM $table " . self::queryWhere(). " 
				{$params} ". self::queryGroup() ." {$orderConditional}  ");
		$total = $total[0]->{"COUNT(*)"};

		return $results = array('rows'=> $result , 'total' => $total);	
	}	

	public static function prevNext( $id ){

       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;

	   $prev = '';
	   $next = '';

		$Qnext = \DB::select( 
			self::querySelect() . 
			self::queryWhere().
			" AND ".$table.".".$key." > '{$id}'  ". 
			self::queryGroup().' LIMIT 1'
		);	


		if(count($Qnext)>=1)   $next = $Qnext[0]->{$key};
		
		$Qprev  = \DB::select( 
			self::querySelect() . 
			self::queryWhere().
			" AND ".$table.".".$key." < '{$id}'". 
			self::queryGroup()." ORDER BY ".$table.".".$key." DESC LIMIT 1"
		);	
		if(count($Qprev)>=1)  $prev = $Qprev[0]->{$key};

		return array('prev'=>$prev , 'next'=> $next);	
	}

	public static function getRow( $id )
	{
       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;

		$result = \DB::select( 
				self::querySelect() . 
				self::queryWhere().
				" AND ".$table.".".$key." = '{$id}' ". 
				self::queryGroup()
			);	
		if(count($result) <= 0){
			$result = array();		
		} else {

			$result = $result[0];
		}
		return $result;		
	}	

	public  function insertRow( $data , $id)
	{
       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;
	    if($id == NULL )
        {
            // Insert Here 
            unset($data[$key]);
			if(isset($data['created_at'])) $data['created_at'] = date("Y-m-d H:i:s");	
			if(isset($data['updated_at'])) $data['updated_at'] = date("Y-m-d H:i:s");	
			$id = \DB::table( $table )->insertGetId($data);				
            
        } else {
            // Update here 
			// update created field if any
			if(isset($data['created_at'])) unset($data['created_at']);	
			if(isset($data['updated_at'])) $data['updated_at'] = date("Y-m-d H:i:s");			
			 \DB::table($table)->where($key,$id)->update($data);    
        }    
        return $id;    
	}			

	static function makeInfo( $id )
	{	
		$row =  \DB::table('tb_module')->where('module_name', $id)->orwhere('module_db', $id)->get();
		$data = array();
		foreach($row as $r)
		{
			$data['id']		= $r->module_id; 
			$data['name'] 	= $r->module_name; 
			$data['title'] 	= $r->module_title; 
			$data['note'] 	= $r->module_note; 
			$data['table'] 	= $r->module_db; 
			$data['key'] 	= $r->module_db_key;
			$data['config'] = \SiteHelpers::CF_decode_json($r->module_config);
			$field = array();	
			foreach($data['config']['grid'] as $fs)
			{
				foreach($fs as $f)
					$field[] = $fs['field']; 	
									
			}
			$data['field'] = $field;	
					
		}
		return $data;
			
	
	} 

    static function getComboselect( $params , $limit =null, $parent = null, $global = 1)
    {   
        $limit = explode(':',$limit);
        $parent = explode(':',$parent);
        $fields = $params[1].",".str_replace("|", ",", $params[2]);
        if(count($limit) >=3)
        {
            $table = $params[0]; 
            $condition = $limit[0]." `".$limit[1]."` ".$limit[2]." ".$limit[3]." "; 
            if(count($parent)>=2 )
            {
            	if($global == 0) {
            		$row =  \DB::select( "SELECT $fields FROM ".$table." ".$condition ." AND ".$parent[0]." = '".$parent[1]."' AND entry_by=".\Auth::user()->id);
            	}else{
            		$row =  \DB::select( "SELECT $fields FROM ".$table." ".$condition ." AND ".$parent[0]." = '".$parent[1]."'");
            	}
            } else  {
            	if($global == 0) {
            		$row =  \DB::select( "SELECT $fields FROM ".$table." ".$condition." AND entry_by=".\Auth::user()->id);
            	}else{
            		$row =  \DB::select( "SELECT $fields FROM ".$table." ".$condition);
            	}
            }        
        }else{

            $table = $params[0];
            if(count($parent)>=2 )
            {
            	if($global == 0) {
            		$row =  \DB::select( "SELECT $fields FROM ".$table." WHERE ".$parent[0]." = '".$parent[1]."' AND entry_by=".\Auth::user()->id);
            	}else{
            		$row =  \DB::select( "SELECT $fields FROM ".$table." WHERE ".$parent[0]." = '".$parent[1]."'");
            	}
            } else  {
            	if($global == 0) {
            		$row =  \DB::select( "SELECT $fields FROM ".$table." WHERE entry_by=".\Auth::user()->id);
            	}else{
            		$row =  \DB::select( "SELECT $fields FROM ".$table);
            	}
            }	           
        }
        return $row;
    }		

	public static function getColoumnInfo( $result )
	{
		$pdo = \DB::getPdo();
		$res = $pdo->query($result);
		$i =0;	$coll=array();	
		while ($i < $res->columnCount()) 
		{
			$info = $res->getColumnMeta($i);			
			$coll[] = $info;
			$i++;
		}
		return $coll;	
	
	}	


	function validAccess( $id, $group_id = 0)
	{
		$row = \DB::table('tb_groups_access')->where('module_id','=', $id)
				->where('group_id','=', $group_id > 0 ? $group_id : @\Auth::user()->group_id)
				->get();
		if(count($row) >= 1)
		{
			$row = $row[0];
			if($row->access_data !='')
			{
				$data = json_decode($row->access_data,true);
			} else {
				$data = array();
			}	
			return $data;		
			
		} else {
			return false;
		}			
	
	}	

	static function getColumnTable( $table )
	{	  
        $columns = array();
	    foreach(\DB::select("SHOW COLUMNS FROM $table") as $column)
        {
           //print_r($column);
		    $columns[$column->Field] = '';
        }
	  

        return $columns;
	}	

	static function getTableList( $db ) 
	{
	 	$t = array(); 
		$dbname = 'Tables_in_'.$db ; 
		foreach(\DB::select("SHOW TABLES FROM {$db}") as $table)
        {
		    $t[$table->$dbname] = $table->$dbname;
        }	
		return $t;
	}	
	
	static function getTableField( $table ) 
	{
        $columns = array();
	    foreach(\DB::select("SHOW COLUMNS FROM $table") as $column)
		    $columns[$column->Field] = $column->Field;
        return $columns;
	}	

}
