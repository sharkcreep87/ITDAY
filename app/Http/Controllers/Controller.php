<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
	{
       	$this->middleware(function ($request, $next) {

			$this->middleware('ipblocked');
            
	        \App::setLocale(env('APP_LANG','en'));
			if (env('APP_MULTILANG') == '1') {
			    \App::setLocale(env('APP_LANG','en'));
			}
            return $next($request);
        });
        
           
	} 	

    function buildSearch( $map = false)
	{

		$keywords = ''; $fields = '';	$param ='';
		$allowsearch = $this->info['config']['forms'];
		foreach($allowsearch as $as) $arr[$as['field']] = $as ;		
		$mapping = '';
		if(isset($_GET['search']) && $_GET['search'] !='')
		{
			$type = explode("|",$_GET['search'] );
			if(count($type) >= 1)
			{
				foreach($type as $t)
				{
					$keys = explode(":",$t);
					if(in_array($keys[0],array_keys($arr))){
						$operate = self::searchOperation($keys[1]);
						if($operate == 'like')
						{
							$param .= " AND ".$arr[$keys[0]]['alias'].".".$keys[0]." LIKE '%".$keys[2]."%%' ";	
							$mapping .= $keys[0].' LIKE '.$keys[2]. '<br />';	
						} else if( $operate =='is_null') {
							$param .= " AND ".$arr[$keys[0]]['alias'].".".$keys[0]." IS NULL ";
							$mapping .= $keys[0].' IS NULL <br />';

						} else if( $operate =='not_null') {
							$param .= " AND ".$arr[$keys[0]]['alias'].".".$keys[0]." IS NOT NULL ";
							$mapping .= $keys[0].' IS NOT NULL <br />';

						} else if( $operate =='between') {
							$param .= " AND (".$arr[$keys[0]]['alias'].".".$keys[0]." BETWEEN '".$keys[2]."' AND '".$keys[3]."' ) ";								
							$mapping .= $keys[0].' BETWEEN '.$keys[2]. ' - '. $keys[3] .'<br />';
						} else {
							$param .= " AND ".$arr[$keys[0]]['alias'].".".$keys[0]." ".self::searchOperation($keys[1])." '".$keys[2]."' ";
							$mapping .= $keys[0].' '.self::searchOperation($keys[1]).' '.$keys[2]. '<br />';	
						}												
					}
				}
			} 
		}

		if($map == true)
		{
			return $param = array(
					'param'	=> $param,
					'maps'	=> '
					<div class="infobox infobox-info fade in" style="font-size:10px;">
					  <button data-dismiss="alert" class="close" type="button"> x </button>  
					 <b class="text-danger"> Search Result </b> :  <br /> '.$mapping.'
					</div>
					'
				);			

		} else {
			return $param;
		}		
	}

	function onSearch( $params )
	{
		// Used for extracting URL GET search 
		$psearch = explode('|',$params);
		$currentSearch = array();
		foreach($psearch as $ps)
		{
			$tosearch = explode(':',$ps);
			if(count($tosearch) >=2)
			$currentSearch[$tosearch[0]] = $tosearch[2]; 
		}
		return $currentSearch;		
	}

	function searchOperation( $operate)
	{
		$val = '';
		switch ($operate) {
			case 'equal':
				$val = '=' ;
				break;
			case 'bigger_equal':
				$val = '>=' ;
				break;
			case 'smaller_equal':
				$val = '<=' ;
				break;				
			case 'smaller':
				$val = '<' ;
				break;
			case 'bigger':
				$val = '>' ;
				break;
			case 'not_null':
				$val = 'not_null' ;
				break;								

			case 'is_null':
				$val = 'is_null' ;
				break;	

			case 'like':
				$val = 'like' ;
				break;	

			case 'between':
				$val = 'between' ;
				break;					

			default:
				$val = '=' ;
				break;
		}
		return $val;
	}	

	function inputLogs(Request $request, $note = NULL)
	{
		$data = array(
			'module'	=> $request->segment(1),
			'task'		=> $request->segment(2),
			'user_id'	=> Session::get('uid'),
			'ipaddress'	=> $request->getClientIp(),
			'note'		=> $note
		);
		\DB::table( 'tb_logs')->insert($data);		;
	}

	function validateForm(Request $request, $id = 0)
	{
		$forms = $this->info['config']['forms'];
		$rules = array();
		foreach($forms as $form)
		{
			if($form['required']== 'required')
			{
				$rules[$form['field']] = 'required';
			} elseif ($form['required'] == 'unique'){
				$rules[$form['field']] = 'required|unique:'.$form['alias'].','.$form['field'].','.$id;
			} elseif ($form['required'] == 'alpa'){
				$rules[$form['field']] = 'required|alpa';
			} elseif ($form['required'] == 'alpa_num'){
				$rules[$form['field']] = 'required|alpa_num';					
			} elseif ($form['required'] == 'alpa_dash'){
				$rules[$form['field']]='required|alpa_dash';
			} elseif ($form['required'] == 'email'){
				$rules[$form['field']] ='required|email';
			} elseif ($form['required'] == 'numeric'){
				$rules[$form['field']] = 'required|numeric';		
			} elseif ($form['required'] == 'date'){
				$rules[$form['field']]='required|date';
			} else if($form['required'] == 'url'){
				$rules[$form['field']] = 'required|active_url';
			} else {
	
				if( $form['type'] =='file' && ($form['required']== '' || $form['required'] !='0'))
				{
					if(!is_null($request->file($form['field'])))
					{

						if($form['option']['upload_type'] =='image')
						{
							$rules[$form['field']] = 'mimes:jpg,jpeg,png,gif,bmp';
						} else {
							if($form['option']['image_multiple'] != '1')
							{
								$rules[$form['field']] = 'mimes:zip,csv,xls,doc,docx,xlsx';
							} 
							
						}						
					}

				}

			}										
		}
		return $rules ;
	}	

	function validatePost( Request  $request, $id = null )
	{	
		$request = $request ? $request : new Request;	
		$str = $this->info['config']['forms'];	
		$data = array();
		foreach($str as $f){
			
			if($f['view'] ==1)
			{

				$data[$f['field']] = $this->getFormData($f, $request, $id);

				if(isset($f['input_group']) && count($f['input_group']) > 0){
					foreach ($f['input_group'] as $input) {
						$data[$input['field']] = $this->getFormData($input, $request, $id); 
					}
				}

			}	
			if($f['field'] == 'created_at') $data['created_at'] = date('Y-m-d H:i:s');
    		if($f['field'] == 'updated_at') $data['updated_at'] = date('Y-m-d H:i:s');
		}

		$global	= (isset($this->access['is_global']) ? $this->access['is_global'] : 0 );
		
		if($global == 0 && !$request->expectsJson())
			$data['entry_by'] = \Auth::user()->id;

		/* Added for Compatibility laravel 5.2 */
		$values = array();
		foreach($data as $key=>$val)
		{
			if($val !='') $values[$key] = $val;
		}			
		return $values;
	}

	function getFormData($f, $request, $id = 0, $bulk = false, $bulk_idx = 0){
		$field = $bulk ? 'bulk_'. $f['field'] : $f['field'];
			
		if($f['type'] =='textarea_editor' || $f['type'] =='textarea')
		{
			// Handle Text Editor 
			if($bulk) {
				$content = (isset($_POST[$field]) ? $_POST[$field][$bulk_idx] : $request->$field[$bulk_idx]);
			}else{
				$content = (isset($_POST[$field]) ? $_POST[$field] : $request->input($field));
			}
			
			$data = $content;
		} else {
			// Handle Text Input
			$input = $bulk ? $request->$field[$bulk_idx] : $request->$field;
			$data = is_array($input) ? json_encode($input) : $input;

			// Handle FILE OR IMAGE Upload 
			if($f['type'] =='file')
			{	
				$files ='';	
				if($f['option']['upload_type'] =='file')
				{
					if(isset($f['option']['image_multiple']) && $f['option']['image_multiple'] ==1)
					{

						if(!is_null($request->file($field)))
						{

							$destinationPath = '.'. $f['option']['path_to_upload']; 	
							foreach($_FILES[$field]['tmp_name'] as $key => $tmp_name ){
							 	$file_name = $_FILES[$field]['name'][$key];
								$file_tmp =$_FILES[$field]['tmp_name'][$key];
								if($file_name !='')
								{
									move_uploaded_file($file_tmp,$destinationPath.'/'.$file_name);
									$files .= $file_name.',';
								}
							}
							if($files !='')	$files = substr($files,0,strlen($files)-1);	
						}	
						$data = $files;													
					} else {
						$file = $bulk ? $request->file($field)[$bulk_idx] : $request->file($field);
						if(!is_null($file))
						{								
						 	$destinationPath = '.'. $f['option']['path_to_upload']; 
							$filename = $file->getClientOriginalName();
							$extension =$file->getClientOriginalExtension(); //if you need extension of the file
							$rand = rand(1000,100000000);
							$newfilename = strtotime(date('Y-m-d H:i:s')).'-'.$rand.'.'.$extension;
							$uploadSuccess = $file->move($destinationPath, $newfilename);
							if( $uploadSuccess ) {
							   $data = $newfilename;
							}
						}	 
					}	

				} else {

					if(!is_null($request->file($field)))
					{
						if(isset($f['option']['image_multiple']) && $f['option']['image_multiple'] ==1){
							$files = $request->file($field);
					 		$destinationPath = '.'. $f['option']['path_to_upload']; 
					 		$upload_filename = array();
					 		foreach ($files as $key => $file) {
								$filename = $this->handleResizeImage($file, $f['option']);
								if( $filename ) {
									if($f['option']['save_full_path'] == 1){
										$upload_filename[] = url('/').'/'.$destinationPath.'/'.$filename;
									}else{
										$upload_filename[] = $filename;
									}
									if(is_array($request->input($field))){
										foreach ($request->input($field) as $val) {
											$upload_filename[] = $val;
										}											
									}
								} 
					 		}
					 		$this->deleteFile($field,$id,$f['option'],$upload_filename);
					 		$data = implode(',', $upload_filename);
						}else{
							if($bulk && isset($request->input($field)[$bulk_idx])){
								$data = $request->input($field)[$bulk_idx];
							} else {
								$file = $bulk ? $request->file($field)[$bulk_idx] : $request->file($field); 
								$destinationPath = '.'. $f['option']['path_to_upload']; 
							 	$filename = $this->handleResizeImage($file, $f['option']);
								if( $filename ) {
									if($f['option']['save_full_path'] == 1){
										$data = url('/').'/'.$destinationPath.'/'.$filename;
									}else{
										$data = $filename;
									}	
									$this->deleteFile($field,$id,$f['option'],[$data]);			
								} 
							}
						}


					} else {
						if($id > 0) {
							$input = $bulk ? $request->$field[$bulk_idx] : $request->$field; 
							if(is_array($input)){
								$this->deleteFile($field,$id,$f['option'],$input);
								$data = implode(',', $input);
							}else{
								$this->deleteFile($field,$id,$f['option'],[$input]);
								$data = $input;
							}
						}
						
					}	

				}
			}	

			// Handle Checkbox input 
			if($f['type'] =='checkbox')
			{
				$input = $bulk ? $request->$field[$bulk_idx] : $request->$field; 
				if($input)
				{
					$data = (is_array($input) ? implode(",",$input) :  $input);
				} else {
					$data = '0';	
				}
			}

			// Handle Date 				
			if($f['type'] =='date')
			{
				$input = $bulk ? $request->$field[$bulk_idx] : $request->$field; 
				$data = date("Y-m-d",strtotime($input));
			}

			// Handle Date 				
			if($f['type'] =='date_time')
			{
				$input = $bulk ? $request->$field[$bulk_idx] : $request->$field; 
				$data = date("Y-m-d H:i:s",strtotime($input));
			}

			
			// if post is seelct multiple						
			if($f['type'] =='select')
			{
				$input = $bulk ? $request->$field[$bulk_idx] : $request->$field; 
				if( isset($f['option']['select_multiple']) &&  $f['option']['select_multiple'] ==1 )
				{
					$multival = is_array($input) ? implode(",",$input) :  $input; 
					$data = $multival;
				} else {
					$data = $input;
				}	
			}	

			// if post is auto val
			if($f['type'] =='auto_val'){
				$input = $bulk ? $request->$field[$bulk_idx] : $request->$field; 
				if($input == null){
					if($f['option']['val_type'] == 'str'){
						if($f['option']['opt_type'] == 'external') {
							$prefix = \DB::table($f['option']['lookup_table'])->where($f['option']['lookup_key'], $request->input($f['option']['lookup_dependency_key']))->value($f['option']['lookup_value']);
							$data = str_random(10);
						} else {
							if(isset($f['option']['str_prefix']) && strlen($f['option']['prefix']) > 0)
								$data = $f['option']['str_prefix'].str_random(10);
							else
								$data = $prefix.str_random(10);
						}
					}else{
						if($f['option']['opt_type'] == 'external') {
							$prefix = \DB::table($f['option']['lookup_table'])->where($f['option']['lookup_key'], $request->input($f['option']['lookup_dependency_key']))->value($f['option']['lookup_value']);
							$data = $prefix.rand(1000000,10000000);
						}else{
							if(isset($f['option']['str_prefix']) && strlen($f['option']['prefix']) > 0)
								$data = $f['option']['str_prefix'].rand(1000000,10000000);
							else
								$data = rand(1000000,10000000);
						}
					}
				}else{
					$data = $input;
				}
				
			}
		}
		return $data;
	}

	function handleResizeImage($file, $option) {
		$rand = rand(100,10000);
		$extension =$file->getClientOriginalExtension(); 
		$filename = strtotime(date('Y-m-d H:i:s')).'-'.$rand.'.'.$extension;
        $file_path = public_path().'/.'.$option['path_to_upload'];
        if(!is_dir($file_path)) mkdir($file_path, 0777, true);
        $file->move($file_path, $filename);
        $size = getimagesize($file_path.'/'.$filename);
        switch(strtolower($size['mime']))
        {
            case 'image/png':
                $source_image = imagecreatefrompng($file_path.'/'.$filename);
                break;
            case 'image/jpeg':
                $source_image = imagecreatefromjpeg($file_path.'/'.$filename);
                break;
            case 'image/gif':
                $source_image = imagecreatefromgif($file_path.'/'.$filename);
                break;
            default: die('image type not supported');
        }

        $resize = explode(",", $option['resize_width']);
        $subfolder = explode(",", $option['sub_foldername']);
        $image = null;
        foreach ($resize as $key => $value) {
        	if($value > 0){

	            $width      = $value; 
	            $height     = round($width*$size[1]/$size[0]);
	            $photoX     = ImagesX($source_image);
	            $photoY     = ImagesY($source_image);
	            $image = ImageCreateTrueColor($width, $height);
	            ImageAlphaBlending($image, false);
	            ImageSaveAlpha($image, true);
	            $transparent = ImageColorAllocateAlpha($image, 255, 255, 255, 127);
	            ImageFilledRectangle($image, 0, 0, $width, $height, $transparent);
	            ImageCopyResampled($image, $source_image, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
	            
	            $quality = isset($option['quality']) && $option['quality'] > 0 ? $option['quality'] : 80;
	            if(isset($subfolder[$key])) {
	            	if(!is_dir($file_path.'/'.$subfolder[$key])) mkdir($file_path.'/'.$subfolder[$key]);
	            	$full_path = $file_path.'/'.$subfolder[$key].'/'.$filename;
	            }else{
	            	if(!is_dir($file_path.'/x'.$value)) mkdir($file_path.'/x'.$value);
	            	$full_path = $file_path.'/x'.$value.'/'.$filename;
	            }

	            if(strtolower($size['mime']) == 'image/png') ImagePNG($image, $full_path);
	            if(strtolower($size['mime']) == 'image/jpeg') ImageJPEG($image, $full_path, $quality);
	            if(strtolower($size['mime']) == 'image/gif') ImageGIF($image, $full_path);

	            if(!$option['save_original_image']) unlink($file_path.'/'.$filename);

        	}
        }

        @ImageDestroy($source_image);
        @ImageDestroy($image);
        return $filename;
	}

	function existFile($files, $file){
		if(is_array($files)){
			foreach ($files as $key => $val) {
				if($val == $file){
					return true;
				}
			}
		}
		return false;
	}

	function deleteFile($field, $id = 0,$option = [], $filenames = []){
		$obj = $this->model->find($id);
		if($obj) {
			$destinationPath = '.'. $option['path_to_upload']; 
			$images = explode(",", $obj[$field]);
			foreach ($images as $old_image) {
				$delete = true;
				foreach ($filenames as $new_image) {
					if($new_image == $old_image) {
						$delete = false;
					}
				}
				if($delete) {
					@unlink($destinationPath.'/'.$old_image);
					$resizeW = explode(",", $option['resize_width']);
					$subFolder = explode(",", $option['sub_foldername']);
					if(count($resizeW) > 0){
						foreach ($resizeW as $key => $w) {
							if (strpos($old_image, 'http://') !== false){
								$url = explode('/', $old_image);
								if(isset($subFolder[$key]))
									@unlink($destinationPath.'/'.$subFolder[$key].'/'.end($url));
								else
									@unlink($destinationPath.'/x'.$w.'/'.end($url));
							}
							if(isset($subFolder[$key]))
								@unlink($destinationPath.'/'.$subFolder[$key].'/'.$old_image);
							else
								@unlink($destinationPath.'/x'.$w.'/'.$old_image);
						}
					}
				}
				
			}
		}
	}

	function deleteBulkFile($field, $obj,$option = []){
		$destinationPath = '.'. $option['path_to_upload']; 
		$files = explode(",", $obj[$field]);
		foreach ($files as $file) {
			@unlink($destinationPath.'/'.$file);
			$resizeW = explode(",", $option['resize_width']);
			$subFolder = explode(",", $option['sub_foldername']);
			if(count($resizeW) > 0){
				foreach ($resizeW as $key => $w) {
					if (strpos($file, 'http://') !== false){
						$url = explode('/', $file);
						if(isset($subFolder[$key]))
							@unlink($destinationPath.'/'.$subFolder[$key].'/'.end($url));
						else
							@unlink($destinationPath.'/x'.$w.'/'.end($url));
					}
					if(isset($subFolder[$key]))
						@unlink($destinationPath.'/'.$subFolder[$key].'/'.$file);
					else
						@unlink($destinationPath.'/x'.$w.'/'.$file);
				}
			}
		}
	}

	function deleteFiles( $ids = array()){
		$forms = $this->info['config']['forms'];
		foreach($forms as $f){
			$field = $f['field'];
			if($f['view'] ==1) 
			{
				// Handle FILE OR IMAGE Upload 
				if($f['type'] =='file')
				{	
					$destinationPath = '.'. $f['option']['path_to_upload']; 
					if($f['option']['upload_type'] =='file')
					{

						if(isset($f['option']['image_multiple']) && $f['option']['image_multiple'] ==1)
						{				

							foreach ($ids as $key => $id) {

								$obj = $this->model->find($id);
								$urls = split(',', $obj[$field]);
								if(count($urls) > 0){
									foreach ($urls as $key => $file) {
										if (strpos($file, 'http://') !== false){
											$url = explode('/', $file);
											@unlink($destinationPath.'/'.end($url));
										}else{
											@unlink($destinationPath.'/'.$file);
										}
											
									}
								}else{
									if (strpos($obj[$field], 'http://') !== false){
										$url = explode('/', $obj[$field]);
										@unlink($destinationPath.'/'.end($url));
									}else{
										@unlink($destinationPath.'/'.$obj[$field]);
									}
								}
							}
																			

						} else {
							foreach ($ids as $key => $id) {

								$obj = $this->model->find($id);
								if (strpos($obj[$field], 'http://') !== false){
									$url = explode('/', $obj[$field]);
									@unlink($destinationPath.'/'.end($url));
								}else{
									@unlink($destinationPath.'/'.$obj[$field]);
								}	

							}
						}	

					} else {
						foreach ($ids as $key => $id) {

							$obj = $this->model->find($id);

							$resizeW = explode(",", $f['option']['resize_width']);
							$resizeH = explode(",", $f['option']['resize_height']);
							$subFolder = explode(",", $f['option']['sub_foldername']);
							if(count($resizeW) > 0){
								foreach ($resizeW as $key => $w) {
									if (strpos($obj[$field], 'http://') !== false){
										$url = explode('/', $obj[$field]);
										if(isset($subFolder[$key]))
											@unlink($destinationPath.'/'.$subFolder[$key].'/'.end($url));
										else
											@unlink($destinationPath.'/x'.$w.'/'.end($url));
									}else{
										if(isset($subFolder[$key]))
											@unlink($destinationPath.'/'.$subFolder[$key].'/'.$obj[$field]);
										else
											@unlink($destinationPath.'/x'.$w.'/'.$obj[$field]);
									}	
								}
								@unlink($destinationPath.'/'.$obj[$field]);
							}else{
								if (strpos($obj[$field], 'http://') !== false){
									$url = explode('/', $obj[$field]);
									@unlink($destinationPath.'/'.end($url));
								}else{
									@unlink($destinationPath.'/'.$obj[$field]);
								}
							}

						}

					}

				}	
			}	
		}

	}

	function injectPaginate()
	{

		$sort 	= (isset($_GET['sort']) 	? $_GET['sort'] : '');
		$order 	= (isset($_GET['order']) 	? $_GET['order'] : '');
		$rows 	= (isset($_GET['rows']) 	? $_GET['rows'] : '');
		$search 	= (isset($_GET['search']) ? $_GET['search'] : '');

		$appends = array();
		if($sort!='') 	$appends['sort'] = $sort; 
		if($order!='') 	$appends['order'] = $order; 
		if($rows!='') 	$appends['rows'] = $rows; 
		if($search!='') $appends['search'] = $search; 
		
		return $appends;
			
	}	

	function returnUrl()
	{
		$pages 	= (isset($_GET['page']) ? $_GET['page'] : '');
		$sort 	= (isset($_GET['sort']) ? $_GET['sort'] : '');
		$order 	= (isset($_GET['order']) ? $_GET['order'] : '');
		$rows 	= (isset($_GET['rows']) ? $_GET['rows'] : '');
		$search 	= (isset($_GET['search']) ? $_GET['search'] : '');
		
		$appends = array();
		if($pages!='') 	$appends['page'] = $pages; 
		if($sort!='') 	$appends['sort'] = $sort; 
		if($order!='') 	$appends['order'] = $order; 
		if($rows!='') 	$appends['rows'] = $rows; 
		if($search!='') $appends['search'] = $search; 
		
		$url = "";
		foreach($appends as $key=>$val)
		{
			$url .= "&$key=$val";
		}
		return $url;
			
	}	

	function detailview( $model , $detail , $id )
	{
		
		$info = $model->makeInfo( $detail['module'] );

		$params = array(
			'params'	=> " And `".$detail['key']."` ='". $id ."'",
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);

		$results = $model->getRows( $params );	
		foreach ( $info['config']['grid'] as $key => $table) {
			foreach ($info['config']['forms'] as $form) {
				if($table['field'] == $form['field']) {
					$info['config']['grid'][$key]['form'] = $form;
				}
			}
		}
		
		$data['rowData']		= $results['rows'];
		$data['tableGrid'] 		= $info['config']['grid'];
		
		return $data;	
	}

	function detailviewsave( $model ,$request , $detail , $id )
	{

		$info = $model->makeInfo( $detail['module'] );

		$access = $model->validAccess( $info['name'] );

		$forms = $info['config']['forms'];

		$delete = $model->where($detail['key'],$id)->whereNotIn('id', array_filter($request['bulk_id']))->get();
		if(count($delete) > 0) {
			foreach ($delete as $key => $obj) {
				foreach ($forms as $f) {
					if($f['type'] == 'file') {
						$this->deleteBulkFile($f['field'], $obj, $f['option']);
					}
				}
				$delete[$key]->delete();
			}
		}

		$data[$detail['master_key']] = $request[$detail['master_key']];

		$data[$detail['key']] = $id;

		$global	= (isset($access['is_global']) ? $access['is_global'] : 0 );
		$total = count($request['counter']);
		foreach ($request['counter'] as $i => $value) {
			foreach($forms as $f){
				$field = $f['field'];
				if($f['view'] ==1)
				{	
					if((isset($request['bulk_'.$field][$i]) && $request['bulk_'.$field][$i] != null) || $f['type'] == 'auto_val')
					{
						$value = $this->getFormData($f, $request, $id, true, $i);
						$data[$f['field']] = $value || $value == 0 ? $value : null;
					}elseif( $data[$f['field']] != $data[$detail['key']]){
						$data[$f['field']] = null;
					}
				}			
			}	
			if($global == 0 )
				$data['entry_by'] = \Auth::user()->id;
			$data['created_at'] = date('Y-m-d H:i:s');
    		$data['updated_at'] = date('Y-m-d H:i:s');
			$model->insertRow($data , $data[$detail['primary_key']]);
		}
	}

	function detailviewapisave( $model , $request , $subform , $id )
	{
		$info = $model->makeInfo( $subform['module'] );
		$access = $model->validAccess( $info['name'] );

		$str = $info['config']['forms'];

		if(isset($request[$subform['master_key']]))
			$data[$subform['master_key']] = $request[$subform['master_key']];
		$data[$subform['key']] = $id;

		$global	= (isset($access['is_global']) ? $access['is_global'] : 0 );
		$subform_id = [];
		foreach ($request["{$subform['module']}"] as $i => $value) {
			if(isset($value->id)) $subform_id[] = $value->id;
			foreach($str as $f){
				$field = $f['field'];
				if($f['view'] ==1)
				{
					if(isset($value["{$field}"]))
					{
						$data[$f['field']] = $value["{$field}"];
					}
				}			
			}
			$data['created_at'] = date('Y-m-d H:i:s');
    		$data['updated_at'] = date('Y-m-d H:i:s');
			$model->insertRow($data , isset($data[$subform['primary_key']]) ? $data[$subform['primary_key']] : NULL);
		}
		if(count($subform_id))
			$model->where($subform['key'],$id)->whereNotIn('id', $subform_id)->delete();
	}

	function getComboselect(Request $request)
    {
        if($request->ajax() == true && \Auth::check() == true)
        {
            $param = explode(':',$request->input('filter'));
            $parent = (!is_null($request->input('parent')) ? $request->input('parent') : null);
            $limit = (!is_null($request->get('limit')) ? $request->get('limit') : null);

            $info = $this->model->makeInfo( $param[0] );
			$access = $this->model->validAccess( $info['name'] );
			$global	= (isset($access['is_global']) ? $access['is_global'] : 0 );

            $rows = $this->model->getComboselect($param,$limit,$parent, $global);

            $items = array();
        
            $fields = explode("|",$param[2]);
            
            foreach($rows as $row) 
            {
                $value = "";
                foreach($fields as $item=>$val)
                {
                    if($val != "") $value .= $row->{$val}." ";
                }
                $items[] = array($row->{$param['1']}, $value);  
    
            }
            
            return json_encode($items);     
        } else {
            return json_encode(array('OMG'=>" Ops .. Cant access the page !"));
        }   
    }

    public function getCombotable( Request $request)
    {
        if($request->ajax() == true)
        {               
            $rows = $this->model->getTableList(env('DB_DATABASE', 'forge'));
            $items = array();
            foreach($rows as $row) $items[] = array($row , $row);   
            return json_encode($items);     
        } else {
            return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
        }               
    }       
    
    public function getCombotablefield( Request $request)
    {
        if($request->input('table') =='') return json_encode(array());  
        if($request->ajax() == true)
        {   
            $items = array();
            $table = $request->input('table');
            if($table !='')
            {
                $rows = $this->model->getTableField($request->input('table'));          
                foreach($rows as $row) 
                    $items[] = array($row , $row);                  
            } 
            return json_encode($items); 
        } else {
            return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
        }                   
    }

    function postMultisearch( Request $request)
    {
        $post = $_POST;
        $items ='';
        foreach($post as $item=>$val):
            if($_POST[$item] !='' and $item !='_token' and $item !='md' && $item !='id'):
                $items .= $item.':'.trim($val).'|';
            endif;  
        
        endforeach;
        
        return redirect('admin/'.$this->module.'?search='.substr($items,0,strlen($items)-1).'&md='.$request->get('md'));
    }

    function postFilter( Request $request)
    {
        $sort   = (!is_null($request->input('sort')) ? $request->input('sort') : '');
        $order  = (!is_null($request->input('order')) ? $request->input('order') : '');
        $rows   = (!is_null($request->input('rows')) ? $request->input('rows') : '');
        $md     = (!is_null($request->input('md')) ? $request->input('md') : '');
        $sc     = (!is_null($request->input('sc')) ? $request->input('sc') : '');
        
        $filter = '?';
        if($sort!='') $filter .= '&sort='.$sort; 
        if($order!='') $filter .= '&order='.$order; 
        if($rows!='') $filter .= '&rows='.$rows; 
        if($md !='') $filter .= '&md='.$md;
        if($sc !='') $filter .= '&search='.$sc;

        return redirect('admin/'.$this->data['pageModule'] . $filter);
    
    }

    public function getSearch()
    {

        $this->data['tableForm']    = $this->info['config']['forms'];   
        $this->data['tableGrid']    = $this->info['config']['grid'];

        $this->data['pageUrl']      = url('admin/'.$this->module);
        return view('core.model.utility.search',$this->data);
    
    }

    function getDownload( Request $request)
    {
    
        if($this->access['is_excel'] ==0) 
            return redirect('')->with('message','Sorry, You are not allowed to access.')->with('status','error');   
    
        $info = $this->model->makeInfo( $this->module);
        // Take param master detail if any
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
        $params = array(
            'params'    => $filter,
            'global'    => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        
        $results    = $this->model->getRows( $params );
        $fields     = $info['config']['grid'];
        $rows       = $results['rows'];
        
        $content = $this->data['pageTitle'];
        $content .= '<table border="1">';
        $content .= '<tr>';
        foreach($fields as $f )
        {
            if($f['download'] =='1')
            {
                $limited = isset($field['limited']) ? $field['limited'] :'';
                if(\SiteHelpers::filterColumn($limited ))
                {
                    $content .= '<th style="background:#f9f9f9;">'. $f['label'] . '</th>';
                    
                }
            }   
        }
        $content .= '</tr>';
        
        foreach ($rows as $row)
        {
            $content .= '<tr>';
            foreach($fields as $f )
            {
                    
                if($f['download'] =='1')
                {
                    $limited = isset($field['limited']) ? $field['limited'] :'';
                    if(\SiteHelpers::filterColumn($limited ))
                    {
                        $content .= '<td> '. \SiteHelpers::formatRows($row->{$f['field']},$f,$row) . '</td>';
                    }
                }   
    
            }
            $content .= '</tr>';
        }
        $content .= '</table>';
        
        @header('Content-Type: application/ms-excel');
        @header('Content-Length: '.strlen($content));
        @header('Content-disposition: inline; filename="'.$title.' '.date("d/m/Y").'.xls"');
        
        echo $content;
        exit;
    
    }

    function getRelation( $subgrid, $id )
    {
        $model = '\\App\\Models\\'.ucwords($subgrid['module']);
        $model = new $model();
        $info = $model->makeInfo( $subgrid['module'] );

        $params = array(
            'params'    => " And ".$subgrid['table'].".".$subgrid['key']." ='". $id ."'"
        );

        $results = $model->getRows( $params );

        return count($results['rows']) > 0 ;
    }   


    function getLookup( Request $request, $id)
    {
        $args = explode("-",$id);
        if(count($args)>=2) 
        {

            $model = '\\App\\Models\\'.ucwords($args['4']);
            $model = new $model();
            $info = $model->makeInfo( $args['4'] );
            $data['pageTitle'] = $info['title'];
            $data['pageNote'] = $info['note'];          
            $params = array(
                'params'    => " And ".$args['5'].".".$args['6']." ='". $args['7'] ."'"
            );
            $results = $model->getRows( $params );  
            $data['access']     = $model->validAccess( $info['name'] );
            $data['rowData']    = $results['rows'];
            $data['tableGrid']  = $info['config']['grid'];
            $data['tableForm']  = $info['config']['forms']; 
            $data['colspan']        = \SiteHelpers::viewColSpan($info['config']['grid']);
            $data['nested_subgrid'] = (isset($info['config']['subgrid']) ? $info['config']['subgrid'] : array());
            //print_r($data['nested_subgrid']);exit;
            $data['id']         = $args[7];
            $data['key']        = $info['key'];
            //$data['ids']      = 'md'-$info['id'];
            return view('core.model.utility.masterdetail',$data);

        } else {
            return 'Invalid Argument';
        }
    }
}
