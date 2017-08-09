<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{controller};
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input ; 


class {controller}Controller extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = '{class}';
	static $per_page	= '10';

	public function __construct()
	{

		$this->middleware(function ($request, $next) {
            parent::__construct();
            $this->model = new {controller}();
			{masterdetailmodel}
			$this->info = $this->model->makeInfo($this->module);
			$this->access = $this->model->validAccess($this->info['name']);
		
			$this->data = array(
				'pageTitle'	=> $this->info['title'],
				'pageNote'	=> $this->info['note'],
				'pageAction'=> 'All '.$this->info['title'],
				'pageModule'=> '{class}',
				'return'	=> self::returnUrl()
				
			);
			
			\App::setLocale(env('APP_LANG'));
			if (env('APP_MULTILANG') == '1') {
				\App::setLocale(env('APP_LANG'));
			}


			{masterdetailinfo}

            return $next($request);
        });
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return redirect(url()->previous())
				->with(['message'=> 'Sorry, You are not allowed to access.','status'=>'error']);

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : ''); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : '');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = '';	
		if(!is_null($request->input('search')))
		{
			$search = 	$this->buildSearch('maps');
			$filter = $search['param'];
			$this->data['search_map'] = $search['maps'];
		} 

		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results = $this->model->getRows( $params );		
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		$pagination->setPath('{class}');
		
		$this->data['rowData']		= $results['rows'];
		// Build Pagination 
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();	
		// Row grid Number 
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// Grid Configuration 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];	
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('{class}.index',$this->data);
	}	



	function getUpdate(Request $request, $id = null)
	{
	
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
				return redirect(url()->previous())
				->with(['message'=> 'Sorry, You are not allowed to access.','status'=>'error']);
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
				return redirect(url()->previous())
					->with(['message'=> 'Sorry, You are not allowed to access.','status'=>'error']);
		}				
				
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['pageAction'] =  'Edit '.$this->info['title'];
		} else {
			$this->data['row'] = $this->model->getColumnTable('{table}'); 
			$this->data['pageAction'] =  'Add '.$this->info['title'];
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		{masterdetailsubform}
		$this->data['id'] = $id;
		return view('{class}.form',$this->data);
	}	

	public function getShow( Request $request, $id = null)
	{

		if($this->access['is_detail'] ==0) 
			return redirect(url()->previous())
				->with(['message'=> 'Sorry, You are not allowed to access.','status'=>'error']);
					
		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['pageAction'] =  'View '.$this->info['title'];
			$this->data['row'] =  $row;
			$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['grid']);
			$this->data['id'] = $id;
			$this->data['access']		= $this->access;
			$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
			$this->data['prevnext'] = $this->model->prevNext($id);
			return view('{class}.view',$this->data);
		} else {
			return redirect('admin/{class}')->with('message','Record Not Found !')->with('status','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm($request, $request->input('{key}'));
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost($request, $request->input('id'));
				
			$id = $this->model->insertRow($data , $request->input('{key}'));
			{masterdetailsave}
			if($request->input('apply'))
			{
				$return = 'admin/{class}/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'admin/{class}?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('{key}') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New data with id['.$id.'] has been successfully inserted!');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with id['.$id.'] has been successfully updated!');
			}
			{email}

			return redirect($return)->with('message','The record has been saved successfully!')->with('status','success');
			
		} else {

			return redirect('admin/{class}/update/'.$request->input('{key}'))->with('message','The following errors occurred !')->with('status','error')
			->withErrors($validator)->withInput();
		}	
	
	}	

	public function postDelete( Request $request)
	{
		
		if($this->access['is_remove'] ==0) 
			return redirect(url()->previous())
				->with(['message'=> 'Sorry, You are not allowed to access.','status'=>'error']);
		// delete multipe rows 
		if(count($request->input('ids')) >=1)
		{
			$this->deleteFiles($request->input('ids'));
			$this->model->destroy($request->input('ids'));
			{masterdetaildelete}
			\SiteHelpers::auditTrail( $request , "ID: ".implode(",",$request->input('ids'))."  , has been successfully removed!");
			// redirect
			return redirect('admin/{class}?return='.self::returnUrl())
        		->with('message', 'The record has been removed successfully!')->with('status','success'); 
	
		} else {
			return redirect('admin/{class}?return='.self::returnUrl())
        		->with('message','No Item Deleted')->with('status','error');				
		}

	}

}