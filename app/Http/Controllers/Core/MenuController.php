<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class MenuController extends Controller
{
    public function index()
    {
    	$data['menus'] = \SiteHelpers::menus('sidebar','all');
    	$data['modules'] = \DB::table('tb_module')->where('module_type','!=','core')->get();
    	$data['groups'] = \DB::table('tb_groups')->get();
    	$data['action'] = url('core/menu');
    	return view('core.menu', $data);
    }

    public function store(Request $request)
    {
    	$rules = array(
			'menu_name'	=> 'required',	
			'active'	=> 'required',	
			'menu_type'	=> 'required',
		);
		$validator = \Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $request->all();
			$arr = [];
			$groups = \DB::table('tb_groups')->get();
			foreach($groups as $g)
			{
				$arr[$g->group_id] = (isset($request->groups[$g->group_id]) ? "1" : "0" );	
			}
			unset($data['_token']);
			unset($data['groups']);
			$data['access_data'] = json_encode($arr);	
			$data['position'] = 'sidebar';
			\DB::table('tb_menu')->insert($data);
			return redirect('core/menu')->with(['message'=>'The menu has been saved successfully.','status'=>'success']);
		}else{
			return redirect('core/menu')->with(['message'=>'The following error occoured.','status'=>'error']);
		}
    }

    public function reorder(Request $request)
    {
    	$rules = array(
			'reorder'	=> 'required'
		);
		$validator = \Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
	    	$menus = json_decode($request->reorder, true);
	    	$child = array();
			$a=0;
			if($menus && count($menus) > 0)
			{
		    	foreach($menus[0] as $m)
				{	
					if(isset($m['children'][0]) && count($m['children'][0]) > 0)
					{
						$b=0;
						foreach($m['children'][0] as $l)					
						{
							if(isset($l['children'][0]) && count($l['children'][0]) > 0)
							{
								$c=0;
								foreach($l['children'][0] as $l2)
								{
									$level3[] = $l2['id'];
									\DB::table('tb_menu')->where('menu_id','=',$l2['id'])
										->update(array('parent_id'=> $l['id'],'ordering'=>$c));
									$c++;	
								}		
							}
							\DB::table('tb_menu')->where('menu_id','=', $l['id'])
								->update(array('parent_id'=> $m['id'],'ordering'=>$b));	
							$b++;
						}							
					}
					\DB::table('tb_menu')->where('menu_id','=', $m['id'])
						->update(array('parent_id'=>'0','ordering'=>$a));
					$a++;		
				}
				return redirect('core/menu')->with(['message'=>'The menu reorder has been saved successfully.','status'=>'success']);
			}
		}else{
			return redirect('core/menu')->with(['message'=>'The following error occoured.','status'=>'error']);
		}
    }

    public function edit($id)
    {
    	$data['row'] = \DB::table('tb_menu')->where('menu_id',$id)->first();
    	$data['menus'] = \SiteHelpers::menus('sidebar','all');
    	$data['modules'] = \DB::table('tb_module')->where('module_type','!=','core')->get();
    	$data['groups'] = \DB::table('tb_groups')->get();
    	$data['action'] = url('core/menu/'.$id);
    	return view('core.menu', $data);
    }

    public function update(Request $request, $id)
    {
    	$rules = array(
			'menu_name'	=> 'required',	
			'active'	=> 'required',	
			'menu_type'	=> 'required',
		);
		$validator = \Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $request->all();
			$arr = [];
			$groups = \DB::table('tb_groups')->get();
			foreach($groups as $g)
			{
				$arr[$g->group_id] = (isset($request->groups[$g->group_id]) ? "1" : "0" );	
			}
			unset($data['_token']);
			unset($data['groups']);
			$data['access_data'] = json_encode($arr);
			\DB::table('tb_menu')->where('menu_id', $id)->update($data);
			return redirect('core/menu/'.$id)->with(['message'=>'The menu has been changed successfully.','status'=>'success']);
		}else{
			return redirect('core/menu/'.$id)->with(['message'=>'The following error occoured.','status'=>'error']);
		}
    }

    public function destroy($id)
    {
    	\DB::table('tb_menu')->where('menu_id', $id)->delete();
    	return redirect('core/menu')->with(['message'=>'The menu has been deleted successfully.','status'=>'success']);
    }
}
