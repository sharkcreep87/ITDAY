<?php
class SiteHelpers
{
	public static function menus( $position ='sidebar', $active = '1')
	{
		$data = array();  
		$menu = self::nestedMenu(0,$position ,$active);		
		foreach ($menu as $row) 
		{
			$child_level = array();
			$p = json_decode($row->access_data,true);
	
			if($row->allow_guest == 1)
			{
				$is_allow = 1;
			} else {
				$is_allow = (isset($p[\Auth::user()->group_id]) && $p[\Auth::user()->group_id] ? 1 : 0);
			}
			if($is_allow ==1) 
			{
				
				$menus2 = self::nestedMenu($row->menu_id , $position ,$active );
				if(count($menus2) > 0 )
				{	 
					$level2 = array();							 
					foreach ($menus2 as $row2) 
					{
						$p = json_decode($row2->access_data,true);
						if($row2->allow_guest == 1)
						{
							$is_allow = 1;
						} else {
							$is_allow = (isset($p[\Auth::user()->group_id]) && $p[\Auth::user()->group_id] ? 1 : 0);
						}						
									
						if($is_allow ==1)  
						{						
					
							$menu2 = array(
									'menu_id'		=> $row2->menu_id,
									'module'		=> $row2->module,
									'menu_type'		=> $row2->menu_type,
									'url'			=> $row2->url,
									'menu_name'		=> $row2->menu_name,
									'menu_lang'		=> json_decode($row2->menu_lang,true),
									'menu_icons'	=> $row2->menu_icons,
									'childs'		=> array()
								);	
												
							$menus3 = self::nestedMenu($row2->menu_id , $position , $active);
							if(count($menus3) > 0 )
							{
								$child_level_3 = array();
								foreach ($menus3 as $row3) 
								{
									$p = json_decode($row3->access_data,true);
									if($row3->allow_guest == 1)
									{
										$is_allow = 1;
									} else {
										$is_allow = (isset($p[\Auth::user()->group_id]) && $p[\Auth::user()->group_id] ? 1 : 0);
									}										
									if($is_allow ==1)  
									{								
										$menu3 = array(
												'menu_id'		=> $row3->menu_id,
												'module'		=> $row3->module,
												'menu_type'		=> $row3->menu_type,
												'menu_name'		=> $row3->menu_name,
												'menu_lang'		=> json_decode($row3->menu_lang,true),
												'menu_icons'	=> $row3->menu_icons,
												'childs'		=> array()
											);	
										$child_level_3[] = $menu3;	
									}					
								}
								$menu2['childs'] = $child_level_3;
							}
							$level2[] = $menu2 ;
						}	
					
					}
					$child_level = $level2;
						
				}
				
				$level = array(
						'menu_id'		=> $row->menu_id,
						'module'		=> $row->module,
						'menu_type'		=> $row->menu_type,
						'url'			=> $row->url,						
						'menu_name'		=> $row->menu_name,
						'menu_lang'		=> json_decode($row->menu_lang,true),
						'menu_icons'	=> $row->menu_icons,
						'childs'		=> $child_level
					);			
				
				$data[] = $level;	
			}	
				
		}
		//echo '<pre>';print_r($data); echo '</pre>'; exit;
		return $data;
	}

	public static function active( $segment, $menu_id)
	{
		$menus = \DB::table('tb_menu')->where('parent_id', $menu_id)->orwhere('menu_id', $menu_id)->get();
		foreach ($menus as $row) {
			if(strlen($segment) > 0 && $segment == strtolower($row->module))
			{
				return true;
			}
		}
		return false;
	}
	
	public static function nestedMenu($parent=0,$position ='sidebar',$active = '1')
	{
		$group_sql = " AND tb_menu_access.group_id ='".Session::get('gid')."' ";
		$active 	=  ($active =='all' ? "" : "AND active ='1' ");
		$query = \DB::select("SELECT tb_menu.* FROM tb_menu WHERE parent_id ='". $parent ."' ".$active." AND position ='{$position}' ORDER BY ordering");					
		return $query;					
	}

	public static function models()
	{
		$models = \DB::table('tb_module')->where('module_type','addon')->get();
		foreach ($models as $i=>$row) {
			$models[$i]->menu = \DB::table('tb_menu')->where('module', $row->module_name)->first();
		}
		return $models;
	}

	public static function CF_encode_json($arr) {
		$str = json_encode( $arr );
		$enc = base64_encode($str );
		$enc = strtr( $enc, 'poligamI123456', '123456poligamI');
		return $enc;
	}
	
	public static function CF_decode_json($str) {
		$dec = strtr( $str , '123456poligamI', 'poligamI123456');
		$dec = base64_decode( $dec );
		$obj = json_decode( $dec ,true);
		return $obj;
	}
		
	public static function avatar( $width = 75 )
	{
		$avatar = '<img alt="" src="https://www.gravatar.com/avatar/'.md5(\Auth::user()->email).'" class="img-circle" width="'.$width.'" />';
		$files =  './uploads/users/'.\Auth::user()->avatar ;
		if(\Auth::user()->avatar !='' ) 	
		{
			if( file_exists($files))
			{
				return  '<img src="'.asset('uploads/users').'/'.\Auth::user()->avatar.'" border="0" width="'.$width.'" class="img-circle" />';
			} else {
				return $avatar;
			}	
		} else {
			return $avatar;
		}
	}

	public static function viewColSpan( $grid )
	{
		$i =0;
		foreach ($grid as $t):
			if($t['view'] =='1') ++$i;
		endforeach;
		return $i;	
	}

	public static function _sort($a, $b) {
	 
		if ($a['sortlist'] == $a['sortlist']) {
		return strnatcmp($a['sortlist'], $b['sortlist']);
		}
		return strnatcmp($a['sortlist'], $b['sortlist']);
	}

	public static function toForm($forms,$layout)
	{
		$f = '';
		usort($forms,"self::_sort"); 
		$block = $layout['column'];
		$block_width = isset($layout['width']) ? $layout['width'] : [];
		$format = $layout['format'];
		$display = $layout['display'];
		$title = explode(",",$layout['title']);
		
		if($format =='tab')
		{
			$f .='<div class="col-xs-12 col-sm-12">
					<ul class="nav nav-tabs">';
			
			for($i=0;$i<$block;$i++)
			{
				$active = ($i==0 ? 'active' : '');
				$tit = (isset($title[$i]) ? $title[$i] : 'None');	
				$f .= '<li class="'.$active.'"><a href="#'.trim(str_replace(" ","",$tit)).'" data-toggle="tab">'.$tit.'</a></li>
				';	
			}
			$f .= '</ul>';		
		}

		if($format =='tab') 
			$f .= '<div class="'.$display.' tab-content">';
		
		for($i=0;$i<$block;$i++)
		{		
			if($block == 4) {
				$class = 'col-xs-12 col-md-3';
			}  elseif( $block ==3 ) {
				$class = 'col-xs-12 col-md-4';
			}  elseif( $block ==2 ) {
				$class = 'col-xs-12 col-md-'.$block_width[$i];
			} else {
				$class = 'col-xs-12 col-md-12';
			}	
			
			$tit = (isset($title[$i]) ? $title[$i] : 'None');	
			// Grid format 
			if($format == 'grid')
			{
				$form_style = $display == 'horizontal' ? 'form' : '';
				$f .= '<div class="'.$form_style.' '.$class.'">'."\n";
			} else {
				$active = ($i==0 ? 'active' : '');
				$f .= '<div class="tab-pane m-t '.$active.'" id="'.trim(str_replace(" ","",$tit)).'">'."\n";		
			}	
			
			
			
			$group = array();
			foreach($forms as $form)
			{
				$tooltip =''; $helptext =''; $required = ''; $has_error = ''; $help_block = '';
				if($form['required'] != '0'){
					$required 	= 	"<span class='asterix'> * </span>";
					$has_error 	= 	"{{ \$errors->has('".$form['field']."') ? 'has-error' : '' }}";
					$help_block = 	'@if ($errors->has("'.$form['field'].'"))'."\n".
									'	<span class="help-block">'."\n".
							        '		<strong>{{ $errors->first("'.$form['field'].'") }}</strong>'."\n".
							        '	</span>'."\n".
						            '	@endif'."\n";
				}
				
				if($form['view'] != 0)
				{
					if($form['field'] !='entry_by')
					{
						if(isset($form['option']['tooltip']) && $form['option']['tooltip'] !='') {

							$tooltip = '<a href="#" data-toggle="tooltip" placement="left" class="tips" title="'. $form['option']['tooltip'] .'"><i class="icon-question2"></i></a>';	
						
						}
						if(isset($form['option']['helptext']) && $form['option']['helptext'] !='') {

							$helptext ='<span class="help-block">'. $form['option']['helptext'] .'</span>'."\n";	
						
						}
						$hidethis = ""; 
						if($form['type'] =='hidden' || $form['type'] =='auto_val') 
							$hidethis ='hidethis';
						
						$inhide = ''; 
						if(count($group) >1) 
							$inhide ='inhide';

						$show = '';
						if($form['type'] =='hidden' || $form['type'] =='auto_val') 
							$show = 'style="display:none;"';

						if(isset($form['limited']) && $form['limited'] !='')
						{
							$limited_start = '	<?php 
													$limited = isset($fields[\''.$form['field'].'\'][\'limited\']) ? $fields[\''.$form['field'].'\'][\'limited\'] :\'\';
													if(SiteHelpers::filterColumn($limited )) 
												{ ?>';
							$limited_end = '	<?php } ?>'; 
						} else {
							$limited_start = '';
							$limited_end = ''; 
						}

						if($form['form_group'] == $i)
						{	
							// Horizotal is normal layout form.
							if($display == 'horizontal')
							{	
								// If hidden field or generate value.		
								if($form['type'] =='hidden' || $form['type'] =='auto_val')
								{
									$f .= self::formShow($form['type'],$form['field'],$form['required'],$form['option']);
								} else {
									// Else not hidden field or auto generate value.
									$f .= $limited_start;
									// Create input group if define input group.
									if(isset($form['input_group']) && count($form['input_group']) > 0){
										$input_group = '';
										foreach ($form['input_group'] as $input) {
											$input_group .= self::formShow($input['type'],$input['field'],$input['required'],$input['option']);
										}
										$form['option']['extend_class'] = $form['option']['extend_class'].' group';
										$f .= 	'<!-- '.$form['label'].'  -->'."\n".
												'<div class="form-group '.$has_error.' '.$hidethis.' '.$inhide.'" '.$show .'>'."\n".
												'	<label for="'.$form['label'].'" class=" control-label col-xs-12 col-md-4 text-left"> '.$form['label'].' '.$required.'</label>'."\n".
												'	<div class="col-xs-12 col-md-7">'."\n".
											  	'		<div class="input-group">'."\n".
											  	'			'.self::formShow($form['type'],$form['field'],$form['required'],$form['option'])."\n".
											  	'			<span class="input-group-btn">'."\n".
											  	'				'.$input_group."\n".
											  	'			</span>'."\n".
											  	'		</div>'.
											  	'		'.$help_block.
											  	'		'. $helptext.
											 	'	</div>'.
											 	'	<div class="col-xs-12 col-md-1">'."\n".
											 	'		'.$tooltip."\n".
											 	'	</div>'."\n".
										  		'</div>'."\n\n";
									}else{
										$f .=	'<!-- '.$form['label'].'  -->'."\n".
												'<div class="form-group '.$has_error.' '.$hidethis.' '.$inhide.'" '.$show .'>'."\n".
												'	<label for="'.$form['label'].'" class=" control-label col-xs-12 col-md-4 text-left"> '.$form['label'].' '.$required.'</label>'."\n".
												'	<div class="col-xs-12 col-md-7">'."\n".
												'  		'.self::formShow($form['type'],$form['field'],$form['required'],$form['option'])."\n".
												'  		'.$help_block.
												'  		'. $helptext.
												' 	</div>'.
												' 	<div class="col-xs-12 col-md-1">'."\n".
												' 		'.$tooltip."\n".
												' 	</div>'."\n".
										  		'</div>'."\n\n";
									}
									$f .= $limited_end;
								}

							} else {
								// For vertical layout form.
								if($form['type'] =='hidden' || $form['type'] =='auto_val')
								{	
									$f .= self::formShow($form['type'],$form['field'],$form['required'],$form['option']);
								} else {
									$f .= $limited_start;

									// Create input group if define input group.
									if(isset($form['input_group']) && count($form['input_group']) > 0){
										$input_group = '';
										foreach ($form['input_group'] as $input) {
											$input_group .= self::formShow($input['type'],$input['field'],$input['required'],$input['option']);
										}
										$form['option']['extend_class'] = $form['option']['extend_class'].' group';
										$f .= 	'<!-- '.$form['label'].'  -->'."\n".
												'<div class="form-group '.$has_error.' '.$hidethis.' '.$inhide.'" '.$show .'>'."\n".
												'	<label for="ipt" class=" control-label "> '.$form['label'].'  '.$required.' '.$tooltip.' </label>'."\n".									
												'	<div class="input-group">'."\n".
												'  		'.self::formShow($form['type'],$form['field'],$form['required'],$form['option'])."\n".
												'  		<span class="input-group-btn">'."\n".
												'  			'.$input_group."\n".
												'  		</span>'."\n".
												'  	</div>'."\n".
												'  	'.$help_block.
												'  	'.$helptext."\n".					
												'</div>'."\n\n";	
									}else{
										$f .= 	'<!-- '.$form['label'].'  -->'."\n".
												'<div class="form-group '.$has_error.' '.$hidethis.' '.$inhide.'" '.$show .'>'."\n".
												'	<label for="ipt" class=" control-label "> '.$form['label'].'  '.$required.' '.$tooltip.'</label>'."\n".									
												'	'.self::formShow($form['type'],$form['field'],$form['required'],$form['option'])."\n".
												'	'.$help_block.
												'	'.$helptext."\n".
												'</div>'."\n\n";
										
									}
									$f .= $limited_end; 									
								}
 							
							
							}	  
						}	  
					}	  
					
				}					
			}
			$f .= "</div>\n";
			
		} 	

		if($format =='tab'){
			$f .=	"</div>\n".
					"</div>\n";
		}
		return $f;
	}

	public static function formShow( $type , $field , $required ,$option = array()){
		$mandatory = '';$placeholder = '';$attribute = ''; $extend_class ='';
		if(isset($option['placeholder']) && $option['placeholder'] !='') {
			$placeholder = 'placeholder="'.$option['placeholder'].'"'; 
		}
		if(isset($option['attribute']) && $option['attribute'] !='') {
			$attribute = $option['attribute']; 
		}
		if(isset($option['extend_class']) && $option['extend_class'] !='') {
			$extend_class = $option['extend_class']; 
		}				
				
		$show = '';
		if($type =='hidden') $show = 'style="display:none;"';	
				
		if($required =='required') { 
			$mandatory = 'required'; 
		}else if($required =='email') {
			$mandatory = " required data-parsley-type='email' ";
		} else if($required =='url') {
			$mandatory = " required data-parsley-type ='url' ";
		} else if($required =='date') {
			$mandatory = " required data-parsley-type ='dateIso' ";
		} else if($required =='numeric') {
			$mandatory = " required data-parsley-type ='number' ";
		} else if($required =='alpa_num') {
			$mandatory = " required data-parsley-type ='alphanum' ";
		} else if($required =='digits') {
			$mandatory = " required data-parsley-type ='digits' ";
		}else {
			$mandatory = '';
		}
		
		switch($type)
		{
			default;
					
				if(isset($option['prefix']) && $option['prefix'] !='' or isset($option['sufix']) && $option['sufix'] !='')
				{
					$form ='<div class="input-group">';
					if($option['prefix'] !='')
						$form .= '	<span class="input-group-addon">'.$option['prefix'].'</span>';
					
						$form .= "	<input type='text' name='{$field}' id='{$field}' value='{{ \$row['{$field}'] }}' {$mandatory} {$attribute} class='form-control {$extend_class}' {$placeholder}/>";
						
					if($option['sufix'] !='')
						$form .= '	<span class="input-group-addon">'.$option['sufix'].'</span>';

	                $form .= '</div>';

				} else {
					// Not sufix or prefix is empty
					$form = "<input type='text' name='{$field}' id='{$field}' value='{{ \$row['{$field}'] }}' {$mandatory}  {$attribute} class='form-control {$extend_class}' {$placeholder}/>";
				}
				
				break;
				
			case 'hidden';
				$form = "{!! Form::hidden('{$field}', \$row['{$field}']) !!}\n";
				break;

			case 'auto_val';
				$form = "{!! Form::hidden('{$field}', \$row['{$field}']) !!}\n";
				break;


			case 'textarea';
				$form = "<textarea name='{$field}' rows='5' id='{$field}' class='form-control {$extend_class}' {$mandatory} {$attribute} {$placeholder}>{{ \$row['{$field}'] }}</textarea>";
				break;

			case 'textarea_editor';
				$form = "<textarea name='{$field}' rows='5' id='editor' class='form-control editor {$extend_class}' {$mandatory} {$attribute} {$placeholder}>{{ \$row['{$field}'] }}</textarea>";
				break;	

			case 'text_tags';
				$form = "<input type='text' name='{$field}' id='{$field}' value='{{ \$row['{$field}'] }}' {$mandatory}  {$attribute} class='form-control {$extend_class}' data-role='tagsinput' {$placeholder}/>\n";
				break;

			case 'text_date';
				$form = "<div class=\"input-group\">\n".
						"	<input  type='text' name='{$field}' id='{$field}' value='{{ \$row['{$field}'] }}' {$mandatory}  {$attribute} class='form-control date {$extend_class}' data-date-format='yyyy-mm-dd' />\n".
						"	<span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>\n".
						"</div>";
				break;
				
			case 'text_time';
				$form = "<div class=\"input-group\">\n".
						"	<input  type='text' name='{$field}' id='{$field}' value='{{ \$row['{$field}'] }}' {$mandatory}  {$attribute} class='form-control {$extend_class}' data-date-format='yyyy-mm-dd' />\n".
						"	<span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>\n".
						"</div>\n";
				break;				

			case 'text_datetime';
				$form = "<div class=\"input-group\">\n".
						"	<input  type='text' name='{$field}' id='{$field}' value='{{ \$row['{$field}'] }}' {$mandatory}  {$attribute} class='form-control datetime {$extend_class}' data-date-format='yyyy-mm-dd h:i:s' />\n".
						"	<span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>\n".
						"</div>\n";
				break;				

			case 'select';
				if($option['opt_type'] =='datalist')
				{
					$optList ='';
					$opt = explode("|",$option['lookup_query']);
					for($i=0; $i<count($opt);$i++) 
					{							
						$row =  explode(":",$opt[$i]);
						for($i=0; $i<count($opt);$i++) 
						{					
							
							$row =  explode(":",$opt[$i]);
							$optList .= " '".trim($row[0])."' => '".trim($row[1])."' , ";
							
						}							
					}	
					$form  =	"<?php \$".$field." = explode(',',\$row['".$field."']); ";
					$form  .= 	"\$".$field."_opt = array(".$optList."); ?>\n";
					
					if(isset($option['select_multiple']) && $option['select_multiple'] ==1)
					{
					 
						$form  .= 	"\t\t\t<select name='{$field}[]' rows='5' {$mandatory} multiple  class='select2 {$extend_class}' > \n";
						$form  .= 	"\t\t\t<?php\n".
									"\t\t\t 	foreach(\$".$field."_opt as \$key=>\$val)\n".
									"\t\t\t 	{\n".
									"\t\t\t		echo \"<option  value ='\$key' \".(in_array(\$key,\$".$field.") ? \" selected='selected' \" : '' ).\">\$val</option>\";\n". 						
									"\t\t\t 	}\n".			
									"\t\t\t?>\n";
						$form .= 	"\t\t\t</select>";
					} else {
						
						$form  .= 	"\t\t\t<select name='{$field}' rows='5' {$mandatory}  class='form-control select2 {$extend_class}' id='{$field}'>\n";
						$form  .= 	"\t\t\t<?php\n".
									"\t\t\t 	foreach(\$".$field."_opt as \$key=>\$val)\n".
									"\t\t\t 	{\n".
									"\t\t\t		echo \"<option  value ='\$key' \".(\$row['".$field."'] == \$key ? \" selected='selected' \" : '' ).\">\$val</option>\";\n".						
									"\t\t\t 	}\n".						
									"\t\t\t?>\n";
						$form .= 	"\t\t\t</select>";				
					
					}
					
				} else {
					
					if(isset($option['select_multiple']) && $option['select_multiple'] ==1)
					{
						$named ="name='{$field}[]' multiple";
						$extend_class .= ' select2-multiple';
					} else {
						$named ="name='{$field}'";

					}
					$form = "<select ".$named." rows='5' id='{$field}' class='form-control select2 {$extend_class}' {$mandatory} {$attribute} ></select>";

				}
				break;	
				
			case 'file';

				if(isset($option['image_multiple']) && $option['image_multiple'] ==1)
				{
					$form = 	'<div class="col-xs-12 fileinput multi_fileupload" data-name="'.$field.'[]">'."\n".
                                '    <span class="btn green btn-file">'."\n".
                                '        <span class="fileinput-new"> Choose file </span>'."\n".
                                '    </span>'."\n".
                                '</div>'."\n".
								'<div class="row" id="image_preview">'."\n".
								'<?php $cr= 0; '."\n".
								'	$row[\''.$field.'\'] = explode(",",$row[\''.$field.'\']);'."\n".
								'?>'."\n".
								'@foreach($row[\''.$field.'\'] as $files)'."\n".
								'	@if(file_exists(\'.'.$option['path_to_upload'].'/\'.$files) && $files !=\'\')'."\n".
								'	<input type="file" name="'.$field.'[]" style="display: none;" />'."\n".
								'	<div class="col-md-4 cr-<?php echo $cr;?>">'."\n".
				                '       <div class="thumbnail">'."\n".
				                '          <div class="image view view-first">'."\n".
				                '            <img style="width: 100%; display: block;" src="{{ url(\'.'.$option['path_to_upload'].'/\'.$files) }}" target="_blank" height="150"/>'."\n".
				                '            <a href="javascript:;" onclick="remove_image(\'cr-<?php echo $cr;?>\');">{{ $files }}<i class="fa fa-close" style="float:right; margin-top: 5px;"></i></a>'."\n".
				                '            <input type="hidden" name="'.$field.'[]" value="{{ $files }}"/>'."\n".
				                '          </div>'."\n".
				                '        </div>'."\n".
				                '      </div>'."\n".
				                '      <?php ++$cr; ?>'."\n".
								'	@endif'."\n".
								'@endforeach'."\n".
								'</div>';
				} else {

					if($option['upload_type'] == 'image'){
		                $form = '<input type="hidden" name="'.$field.'" value="{{ $row[\''.$field.'\'] }}"> </span>'."\n".
								'<div class="form-control fileinput fileinput-new @if($row[\''.$field.'\'] ==\'\') required @endif " data-provides="fileinput" style="border: none;">'."\n".
		                        '    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">'."\n".
		                        '    @if(file_exists(\'.'.$option['path_to_upload'].'/\'.$row[\''.$field.'\']) && $row[\''.$field.'\'] !=\'\')'."\n".
		                        '    	<img src="{{asset(\'.'.$option['path_to_upload'].'/\'.$row["'.$field.'"])}}" alt="" />'."\n".
		                        '    @else'."\n".
		                        '        <img src="https://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />'. "\n".
		                        '    @endif'."\n".
		                        '    </div>'."\n".
		                        '    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>'."\n".
		                        '    <div>'."\n".
		                        '        <span class="btn default btn-file">'."\n".
		                        '            <span class="fileinput-new"> Select image </span>'."\n".
		                        '            <span class="fileinput-exists"> Change </span>'."\n".
		                        '            <input type="file" name="'.$field.'" id="'.$field.'"> </span>'."\n".
		                        '        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>'."\n".
		                        '    </div>'."\n".
		                        '</div>';
					}else{
						$form = '<div class="fileinput fileinput-new @if($row[\''.$field.'\'] ==\'\') required @endif" data-provides="fileinput">'."\n".
	                            '    <input type="hidden" name="'.$field.'"  value="{{ $row[\''.$field.'\'] }}"> </span>'."\n".
	                            '    <div class="input-group input-large">'."\n".
	                            '        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">'."\n".
	                            '            <i class="fa fa-file fileinput-exists"></i>&nbsp;'."\n".
	                            '            <span class="fileinput-filename"> </span>'."\n".
	                            '        </div>'."\n".
	                            '        <span class="input-group-addon btn default btn-file">'."\n".
	                            '            <span class="fileinput-new"> Select file </span>'."\n".
	                            '            <span class="fileinput-exists"> Change </span>'."\n".
	                            '            <input type="file" name="'.$field.'" id="'.$field.'"> </span>'."\n".
	                            '        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>'."\n".
	                            '    </div>'."\n".
	                            '</div>';
					}

				}
				break;						
				
			case 'radio';
				$opt = explode("|",$option['lookup_query']);
				$form = '<div class="form col-xs-12">'."\n";
				$form .="\t<div class='icheck-control'>\n";
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]);
					$form .="\t<label class='radio-inline icheck'>\n".
							"\t	<input type='radio' name='{$field}' value ='".ltrim(rtrim($row[0]))."' {$mandatory} {$attribute} class='icheck {$extend_class}' ";
					$form .="	@if(\$row['".$field."'] == '".ltrim(rtrim($row[0]))."') checked=\"checked\" @endif";
					$form .=" > ".$row[1]." </label>\n";
				}
				$form .="\t</div>\n";
				$form .='</div>';
				break;
				
			case 'checkbox';
				$opt = explode("|",$option['lookup_query']);
				$form = "<div class='form col-xs-12'>\n".
						"<?php \$".$field." = explode(\",\",\$row['".$field."']); ?>\n";
				$form .="\t<div class='icheck-control'>\n";
				for($i=0; $i<count($opt);$i++) 
				{
					
					$checked = '';
					$row =  explode(":",$opt[$i]);					
					$form .="\t<label class='checked checkbox-inline icheck'>". 
							"\t	<input type='checkbox' name='{$field}[]' value ='".ltrim(rtrim($row[0]))."' {$mandatory} {$attribute} class='icheck {$extend_class}' ";
					$form .="	@if(in_array('".trim($row[0])."',\$".$field."))checked @endif";
					$form .=" /> ".$row[1]."</label>\n";					
				}
				$form .="\t</div>\n";
				$form .="</div>";
				break;				
			
		}
		
		return $form;		
	}

	public static  function transForm( $field, $forms = array(), $bulk=false , $value ='', $class = '', $search_form = false)
	{
		$type = ''; 
		$bulk = ($bulk == true ? '[]' : '');
		$mandatory = '';
		foreach($forms as $f)
		{
			if($f['field'] == $field)
			{
				$type = $f['type']; 
				$option = $f['option'];
				$required = $f['required'];

				if($search_form && $type == 'file') $type = 'text';
				
				if($required =='required') {
					$mandatory = "required data-parsley-required='true'";
				} else if($required =='email') {
					$mandatory = "required data-parsley-type'='email' ";
				} else if($required =='date') {
					$mandatory = "required data-parsley-required='true'";
				} else if($required =='numeric') {
					$mandatory = "required data-parsley-type='number' ";
				} else {
					$mandatory = '';
				}				
			}	
		}
		
		switch($type)
		{
			default;
				$form ="<input  type='text' name='".$field."{$bulk}' class='form-control {$class}' $mandatory value='{$value}'/>";
				break;

			case 'textarea';			
				$form = "<input  type='text' name='".$field."{$bulk}' class='form-control {$class}' $mandatory value='{$value}'/>";
				break;

			case 'textarea_editor';			
				$form = "<input  type='text' name='".$field."{$bulk}' class='form-control {$class}' $mandatory value='{$value}'/>";
				break;

			case 'text_tags';			
				$form = "<input  type='text' name='".$field."{$bulk}' class='form-control {$class}' $mandatory value='{$value}' placeholder='Tags: use \",\"'/>";
				break;

			case 'file';			
				$form = "<input  type='text' name='".$field."{$bulk}' class='{$class}' $mandatory value='{$value}'/>";
				break;

			case 'text_date';
				$form = "<input  type='text' name='$field{$bulk}' class='date form-control {$class}' $mandatory value='{$value}'/> ";
				break;

			case 'text_datetime';
				$form = "<input  type='text' name='$field{$bulk}'  class='datetime form-control {$class}'  $mandatory value='{$value}'/> ";
				break;				

			case 'select';
				
			
				if($option['opt_type'] =='external')
				{
					
					$columns = explode("|",$option['lookup_value']);
					array_push($columns, $option['lookup_key']);
					$data = DB::table($option['lookup_table'])->get($columns);
					$opts = '';
					foreach($data as $row):
						$selected = '';
						if($value == $row->{$option['lookup_key']}) $selected ='selected="selected"';
						$fields = explode("|",$option['lookup_value']);
						$val = "";
						foreach($fields as $item=>$v)
						{
							if($v !="") $val .= $row->{$v}." " ;
						}
						$opts .= "<option $selected value='".$row->{$option['lookup_key']}."' $mandatory > ".$val." </option> ";
					endforeach;
						
				} else {
					$opt = explode("|",$option['lookup_query']);
					$opts = '';
					for($i=0; $i<count($opt);$i++) 
					{
						$selected = ''; 
						if($value == ltrim(rtrim($opt[0]))) $selected ='selected="selected"';
						$row =  explode(":",$opt[$i]); 
						$opts .= "<option $selected value ='".trim($row[0])."' > ".$row[1]." </option> ";
					}				
					
				}
				$multiple = isset($option['select_multiple']) && $option['select_multiple'] == 1 ? 'multiple' : '';
				$form = "<select name='$field{$bulk}'  class='form-control  select2 {$class}' $mandatory $multiple>
							<option value=''> -- Select  -- </option>
							$opts
						</select>";
				break;	

			case 'radio';
			
				$opt = explode("|",$option['lookup_query']);
				$opts = '';
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]);
					$opts .= "<option value ='".$row[0]."' > ".$row[1]." </option> ";
				}
				$form = "<select name='$field{$bulk}' class='form-control select2 {$class}' $mandatory ><option value='0'> -- Select  -- </option>$opts</select>";
				break;	

			case 'checkbox';
			
				$opt = explode("|",$option['lookup_query']);
				$opts = '';
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]);
					$opts .= "<option value ='".$row[0]."' > ".$row[1]." </option> ";
				}
				$form = "<select name='$field{$bulk}' class='form-control  select2 {$class}' $mandatory multiple>$opts</select>";
				break;													
			
		}
		
		return $form;	
	}

	public static  function bulkForm( $field, $f = array(),$i = 0, $value ='')
	{
		$type = ''; 
		$bulk ='true';
		$bulk = ($bulk == true ? '['.$i.']' : '');
		$mandatory = '';
		$placeholder = '';
		if($f['field'] == $field && $f['search'] ==1)
		{
			$class = isset($f['class']) ? $f['class'] : '';
			$type = $f['type'];
			$option = $f['option'];
			$required = $f['required'];

			if(isset($option['placeholder']) && $option['placeholder'] !='') {
				$placeholder = 'placeholder="'.$option['placeholder'].'"'; 
			}
			
			if($required =='required') {
				$mandatory = "data-parsley-required='true'";
			} else if($required =='email') {
				$mandatory = "required data-parsley-type'='email' ";
			} else if($required =='date') {
				$mandatory = "required data-parsley-type='date' ";
			} else if($required =='numeric') {
				$mandatory = "required data-parsley-type='number' ";
			} else if($required =='alpa_num') {
				$mandatory = "required data-parsley-type='alphanum' ";
			} else {
				$mandatory = '';
			}				
		}	
		$field = 'bulk_'.$field;
		
		switch($type)
		{
			default;
				$form ='';
				break;
			case 'auto_val';			
				$form = "<input  type='hidden' name='".$field."{$bulk}' class='form-control' value='{$value}'/>";
				break;
			case 'text';			
				$form = "<input  type='text' name='".$field."{$bulk}' class='form-control' $mandatory {$placeholder} value='{$value}'/>";
				break;

			case 'text_tags';			
				$form = "<input  type='text' name='".$field."{$bulk}' class='form-control tags' $mandatory {$placeholder} value='{$value}'/>";
				break;

			case 'textarea';			
				$form = "<input  type='text' name='".$field."{$bulk}' class='form-control' $mandatory {$placeholder} value='{$value}'/>";
				break;

			case 'text_date';
				$form = "<input  type='text' name='$field{$bulk}' class='date form-control' $mandatory {$placeholder} value='{$value}'/> ";
				break;

			case 'text_datetime';
				$form = "<input  type='text' name='$field{$bulk}'  class='date form-control'  $mandatory {$placeholder} value='{$value}'/> ";
				break;				

			case 'select';
				
				if($option['opt_type'] =='external')
				{
					$data_url = url("admin/{$class}/comboselect?filter={$option['lookup_table']}:{$option['lookup_key']}:{$option['lookup_value']}");
					$is_dependency = $option['is_dependency'];
					$data_dependency = $option['lookup_dependency_key'];
					$columns = explode("|",$option['lookup_value']);
					array_push($columns, $option['lookup_key']);
					$data = DB::table($option['lookup_table'])->get($columns);
					$opts = '';
					foreach($data as $row):
						$selected = '';
						if($value == $row->{$option['lookup_key']}) $selected ='selected="selected"';
						$fields = explode("|",$option['lookup_value']);
						//print_r($fields);exit;
						$val = "";
						foreach($fields as $item=>$v)
						{
							if($v !="") $val .= $row->{$v}." " ;
						}
						$opts .= "<option $selected value='".$row->{$option['lookup_key']}."' $mandatory > ".$val." </option> ";
					endforeach;

					$form = "<select name='$field{$bulk}' id='$field' data-url='$data_url' data-isdependency='$is_dependency' data-dependency='$data_dependency' class='form-control select2' $mandatory >
							$opts
						</select>";
						
				} else {
					$opt = explode("|",$option['lookup_query']);
					$opts = '';
					for($i=0; $i<count($opt);$i++) 
					{
						$selected = ''; 
						if($value == ltrim(rtrim($opt[0]))) $selected ='selected="selected"';
						$row =  explode(":",$opt[$i]); 
						$opts .= "<option $selected value ='".trim($row[0])."' > ".$row[1]." </option> ";
					}

					$form = "<select name='$field{$bulk}' id='$field' class='form-control select2' $mandatory >
							$opts
						</select>";				
					
				}

				
				break;	

			case 'radio';
			
				$opt = explode("|",$option['lookup_query']);
				$opts = '';
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]);
					$opts .= "<option value ='".$row[0]."' > ".$row[1]." </option> ";
				}
				$form = "<select name='$field{$bulk}' class='form-control select2' $mandatory ><option value=''> -- Select  -- </option>$opts</select>";
				break;	
			case 'file';
				if($option['upload_type'] == 'image'){
					if(file_exists('.'.$option['path_to_upload'].'/'.$value) && $value != ''){
						$previewImage = '<img src="'.asset('.'.$option['path_to_upload'].'/'.$value).'" alt="" />';
					}else{
						$previewImage = '<img src="http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />';
					}
					$form = '<div class="bulk_fileinput" data-name="'.$field.'['.$i.']">
		                        <div class="fileinput-preview thumbnail" style="width: 50px; height: 50px;"> 
		                        	'.$previewImage.'
		                        </div>
		                        <div class="fileinput hide">
		                        	<input type="hidden" name="'.$field.'['.$i.']" value="'.$value.'" />
		                        </div>
		                    </div>';
				}else{
					$form = "<input  type='file' name='".$field."{$bulk}' class='' $mandatory {$placeholder} value='{$value}'/>";
				}
				
				break;											
			
		}
		
		return $form;	
	}

	public static function toMasterDetail( $info )
	{
		 if(count($info)>=1)
		 {
		 	$module = ucwords($info['module']);
		 	
		 	$data['masterdetailinfo'] 		= "\$this->data['subgrid']	= (isset(\$this->info['config']['subgrid']) ? \$this->info['config']['subgrid'][0] : array()); ";
		 	$data['masterdetailgrid'] 		= "\$this->data['subgrid'] = \$this->detailview(\$this->modelview ,  \$this->data['subgrid'] ,\$id );";	
		 	$data['masterdetailsave'] 		= "\$this->detailviewsave( \$this->modelview , \$request ,\$this->info['config']['subform'] , \$id) ;";
		 	$data['masterdetailapisave'] 	= "\$this->detailviewapisave( \$this->modelview , \$request->all() ,\$this->info['config']['subform'] , \$id) ;";
		 	$data['masterdetailsubform'] 	=  "\$this->data['subform'] = \$this->detailview(\$this->modelview ,  \$this->info['config']['subform'] ,\$id );";
		 	$tpl = array();

		 	include('../resources/views/core/template/masterdetailform.php');
	
		 	$data['masterdetailview'] 	= $tpl['masterdetailview'];
		 	$data['masterdetailform'] 	= $tpl['masterdetailform'];
		 	$data['masterdetailjs'] 	= $tpl['masterdetailjs'];
		 	$data['masterdetaildelete']	= $tpl['masterdetaildelete'];
		 	$data['masterdetailmodel'] 	= $tpl['masterdetailmodel'];
		 }
		 return $data;
	}

	public static function filterColumn( $limit )
	{
		if($limit !='')
		{
			$limited = explode(',',$limit);	
			if(in_array( \Session::get('uid'),$limited) )
			{
				return  true;
			} else {
				return false;	
			}
		} else {
			return true;
		}
	}
	
	public static function toView( $grids )
	{
		usort($grids,"self::_sort");
		$f = '';
		foreach($grids as $grid)
		{
			if(isset($grid['conn']) && is_array($grid['conn']))
			{
				$conn = $grid['conn'];
				//print_r($conn);exit;
			} else {
				$conn = array('valid'=>0,'db'=>'','key'=>'','display'=>'');
			}

			// IF having Connection
			if($conn['valid'] =='1') {
				$c = implode(':',$conn);
				$val = "{{ SiteHelpers::formatLookUp(\$row->".$grid['field'].",'".$grid['field']."','$c') }}";
			}			
			
			if($grid['detail'] =='1')  
			{
				$format_as = (isset($grid['format_as']) ? $grid['format_as'] : '' );
				$format_value = (isset($grid['format_value']) ?  $grid['format_value'] : '');

				preg_match('~{([^{]*)}~i',$format_value, $match);
				if(isset($match[1]))
				{
					$real_value = '{{$row->'.$match[1].'}}';
					$format_value	= str_replace($match[0],$real_value,$format_value);
				}

				if($format_as =='radio' or $format_as =='file' or $format_as == 'checkbox' or $format_as =='image' or $format_as =='database'){
					$val = "{!! SiteHelpers::formatRows(\$row->".$grid['field'].",\$fields['".$grid['field']."'],\$row ) !!}";
				} elseif($format_as =='link') {


					if($conn['valid'] =='1') {
						$val = $val;
					} else {
						$val = '{{ $row->'.$grid['field'].'}}'; 	
					}
					$val = '<a href="'.$format_value.'">'.$val.' </a>';

				
				} elseif($format_as =='date') {
					$val = "{{ date('".$format_value."',strtotime(\$row->".$grid['field'].")) }}";
				} else {
					if($conn['valid'] =='1') {
						$val = $val;
					} else {
						$val = '{{ $row->'.$grid['field'].'}}'; 	
					}  	
				} 				

					if(isset($grid['limited']) && $grid['limited'] !='')
					{
						$limited_start = 
						'
			<?php 
			$limited = isset($fields[\''.$grid['field'].'\'][\'limited\']) ? $fields[\''.$grid['field'].'\'][\'limited\'] :\'\';
			if(SiteHelpers::filterColumn($limited )) { ?>
						';
						$limited_end = '
			<?php } ?>'; 
					} else {
						$limited_start = '';
						$limited_end = ''; 
					}

				$f .= $limited_start;
				$f .= "
					<tr>
						<td width='30%' class='label-view text-right'>".$grid['label']."</td>
						<td>".$val." </td>
						
					</tr>
				";
				$f .= $limited_end;
			}
		}
		return $f;
	}

	public static function formatLookUp($val , $field, $arr )
	{
		$arr = explode(':',$arr);
		
		if(isset($arr['0']) && $arr['0'] ==1)
		{
			$Q = \DB::select(" SELECT ".str_replace("|",",",$arr['3'])." FROM ".$arr['1']." WHERE ".$arr['2']." = '".$val."' ");
			if(count($Q) >= 1 )
			{
				$row = $Q[0];
				$fields = explode("|",$arr['3']);
				$v= '';
				$v .= (isset($fields[0]) && $fields[0] !='' ?  $row->{$fields[0]}.' ' : '');
				$v .= (isset($fields[1]) && $fields[1] !=''  ? $row->{$fields[1]}.' ' : '');
				$v .= (isset($fields[2]) && $fields[2] !=''  ? $row->{$fields[2]}.' ' : '');
				return $v;
			} else {
				return '';
			}
		} else {
			return $val;
		}		
	}

	public static function formatRows( $value ,$attr , $row = null )
	{

		$conn = (isset($attr['conn']) ? $attr['conn'] :array('valid'=>0,'db'=>'','key'=>'','display'=>'') );
		$field = $attr['field'];
		$format_as = (isset($attr['format_as']) ?  $attr['format_as'] : '');
		$format_value = (isset($attr['format_value']) ?  $attr['format_value'] : '');


		if ($conn['valid'] =='1'){
			$value = self::formatLookUp($value,$attr['field'],implode(':',$conn));
		}

		
		preg_match('~{([^{]*)}~i',$format_value, $match);
		if(isset($match[1]))
		{
			$real_value = $row->{$match[1]};
			$format_value	= str_replace($match[0],$real_value,$format_value);
		}

		if($format_as =='image')
		{
			// FORMAT AS IMAGE
			$vals = '';
			$values = explode(',',$value);

				foreach($values as $val)
				{
					if($val != '')
					{
						if(strpos($format_value, 'http://') !== false || strpos($format_value, 'https://') !== false) {
							$vals .= '<a href="'.$format_value.'/'.$val.'" target="_blank" class="previewImage"><img src="'.$format_value.'/'.$val.'" border="0" width="30" class="img-circle" style="margin-right:2px;" /></a>';
						} elseif(file_exists('.'.$format_value ."/". $val)){
							$vals .= '<a href="'.url( '.'.$format_value ."/". $val).'" target="_blank" class="previewImage"><img src="'.asset( '.'.$format_value ."/". $val ).'" border="0" width="30" class="img-circle" style="margin-right:2px;" /></a>';
						}
					}
				}	 
		    $value = $vals;

		} else if($format_as =='link') {
			// FORMAT AS LINK
			$link = $format_value ? $format_value : $value;
			$value = '<a href="'.$link.'">'.$value.'</a>';

		} else if($format_as =='date') {
			// FORMAT AS DATE
			if($format_value !='')
			{
				$value = date("$format_value",strtotime($value));
			}

		} else if($format_as == 'file') {
			// FORMAT AS FILES DOWNLOAD
			$vals = '';
			$values = explode(',',$value);
			foreach($values as $val)
			{

				if(file_exists('.'.$format_value . $val))				
					$vals .= '<a href="'.asset('.'.$format_value. $val ).'"> '.$val.' </a><br />';
			}
			$value = $vals ;

		} else if( $format_as =='database') {
			// Database Lookup
			$fields = explode("|",$format_value);
			if(count($fields)>=2)
			{

				$field_table  =  str_replace(':',',',$fields[2]);
				$field_toShow =  explode(":",$fields[2]);
				//echo " SELECT ".$field_table." FROM ".$fields[0]." WHERE ".$fields[1]." IN(".$value.") ";
				$Q = \DB::select(" SELECT ".$field_table." FROM ".$fields[0]." WHERE ".$fields[1]." IN(".$value.") ");
				if(count($Q) >= 1 )
				{
					$value = '';
					foreach($Q as $qv)
					{
						$sub_val = '';
						foreach($field_toShow as $fld)
						{
							$sub_val .= $qv->{$fld}.' '; 
						}	
						$value .= $sub_val.', ';					

					}
					$value = substr($value,0,($value-2));
				} 

			}	


		} else if($format_as == 'checkbox' or $format_as =='radio') {
			// FORMAT AS RADIO/CHECKBOX VALUES
				
				$values = explode(',',$format_value);
				if(count($values)>=1)
				{
					for($i=0; $i<count($values); $i++)
					{
						$val = explode(':',$values[$i]);
						if(trim($val[0]) == $value) $value = $val[1];	
					}
								
				} else {

					$value = '';	
				}
								

		} else if($format_as == 'limit'){
			if(strlen($value) > $format_value)
			{
				$value = substr($value, 0, $format_value).'...';
			}
		} else if($format_as == 'number_format'){
			if(strlen($value) > $format_value)
			{
				if(is_numeric($format_value)) {
					$value = number_format($value, $format_value);
				} else {
					$value = number_format($value);
				}
			}
		}

		return $value;	 
	} 

	public static function formatAPI( $row, $conf, $detail = false){
		$data = null;
		foreach ($conf['grid'] as $key=>$grid) {
			if($grid['api'] == 1 || $detail == true){
				if($detail == true && isset($conf['form'][$key]['api']) && $conf['form'][$key]['api']== 1) {
					$data[$grid['field']] = $row->{$grid['field']};
				} elseif ($grid['api'] == 1) {
					$data[$grid['field']] = $row->{$grid['field']};
				}
			}
		}
		if(isset($conf['subgrid'])) {
			foreach ($conf['subgrid'] as $sub) {
				if($sub['relation'] == 'hasMany'){
					if (strpos($row->{$sub['master_key']}, ',') !== false) {
						${$sub['module']} = \DB::table($sub['table'])->wherein($sub['key'], explode(',', $row->{$sub['master_key']}))->get();
					}else{
						${$sub['module']} = \DB::table($sub['table'])->where($sub['key'], $row->{$sub['master_key']})->get();
					}
					$module = \DB::table('tb_module')->where('module_name', $sub['module'])->first();
					$rows = [];
					foreach (${$sub['module']} as $value) {
						if($value) {
							$rows[] = static::formatAPI($value, \SiteHelpers::CF_decode_json($module->module_config), $detail);
						}
					}
					$data[$sub['title']] = $rows;
					
				}else{
					${$sub['module']} = \DB::table($sub['table'])->where($sub['key'], $row->{$sub['master_key']})->first();
					if(${$sub['module']}) {
						$module = \DB::table('tb_module')->where('module_name', $sub['module'])->first();
						$data[$sub['title']] = static::formatAPI(${$sub['module']}, \SiteHelpers::CF_decode_json($module->module_config), $detail);
					}else{
						$data[$sub['title']] = null;
					}
				}
				
			}
		}
		return $data;
	}

	public static function gridDisplayView($val , $field, $arr) {
		$arr = explode(':',$arr);
		
		if(isset($arr['0']) && $arr['0'] ==1)
		{
			$Q = \DB::select(" SELECT ".str_replace("|",",",$arr['3'])." FROM ".$arr['1']." WHERE ".$arr['2']." = '".$val."' ");
			if(count($Q) >= 1 )
			{
				$row = $Q[0];
				$fields = explode("|",$arr['3']);
				$v= '';
				$v .= (isset($fields[0]) && $fields[0] !='' ?  $row->{$fields[0]}.' ' : '');
				$v .= (isset($fields[1]) && $fields[1] !=''  ? $row->{$fields[1]}.' ' : '');
				$v .= (isset($fields[2]) && $fields[2] !=''  ? $row->{$fields[2]}.' ' : '');
				return $v;
			} else {
				return '';
			}
		} else {
			return $val;
		}	
	}

	public static function blend($str,$data) {
		$src = $rep = array();
		foreach($data as $k=>$v){
			$src[] = "{".$k."}";
			$rep[] = $v;
		}
		if(is_array($str)){
			foreach($str as $st ){
				$res[] = trim(str_ireplace($src,$rep,$st));
			}
		} else {
			$res = str_ireplace($src,$rep,$str);
		}
		return $res;	
	}

	public static function toJavascript( $forms , $app , $class )
	{
		$f = '';
		foreach($forms as $form){
			if($form['view'] != 0)
			{			
				if(preg_match('/(select)/',$form['type'])) 
				{
					if($form['option']['opt_type'] == 'external') 
					{
						$table 	=  $form['option']['lookup_table'] ;
						$val 	=  $form['option']['lookup_value'];
						$key 	=  $form['option']['lookup_key'];
						$lookey = '';
						if($form['option']['is_dependency']) $lookey .= $form['option']['lookup_dependency_key'] ;
						$f .= self::createPreCombo( $form['field'] , $table , $key , $val ,$app, $class , $lookey  );
							
					}
									
				}
				
			}	
		
		}
		return $f;	
	
	}
	
	public static function createPreCombo( $field , $table , $key ,  $val ,$app ,$class ,$lookey = null)
	{
		$parent = null;
		$parent_field = null;
		if($lookey != null)  
		{	
			$parent = " parent: '#".$lookey."',";
			$parent_field =  "&parent={$lookey}:";
		}	
		$pre_jCombo = "
		\$(\"#{$field}\").jCombo(\"{!! url('admin/{$class}/comboselect?filter={$table}:{$key}:{$val}') !!}$parent_field\",
		{ ".$parent." selected_value : '{{ \$row[\"{$field}\"] }}' });
		";	
		return $pre_jCombo;
	}

	public static function auditTrail( $request , $note )
	{
		$data = array(
			'module'	=> $request->segment(1),
			'task'		=> $request->segment(2),
			'user_id'	=> @\Auth::user()->id,
			'ipaddress'	=> $request->getClientIp(),
			'note'		=> $note
		);
		
		\DB::table( 'tb_logs')->insert($data);
	}

	static public function fieldLang( $fields ) 
	{ 
		$l = array();
		foreach($fields as $fs)
		{			
			foreach($fs as $f)
				$l[$fs['field']] = $fs; 									
		}
		return $l;	
	}

	static public function displayNoti($status, $title, $message)
	{
        echo "$(document).ready(function(){
				toastr.$status($title, $message);
				toastr.options = {
					  'closeButton': true,
					  'debug': false,
					  'positionClass': 'toast-top-right',
					  'onclick': null,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut'

					}
			 });";	
	}
		
}
