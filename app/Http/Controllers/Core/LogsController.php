<?php namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\Logs;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class LogsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'logs';
	static $per_page	= '10';

	public function __construct()
	{
		
		parent::__construct();
		$this->middleware(function ($request, $next) {
            
            $this->model = new Logs();
			$this->info = $this->model->makeInfo( $this->module);
			$this->access = $this->model->validAccess($this->info['name']);
		
			$this->data = array(
				'pageTitle'	=> 	$this->info['title'],
				'pageNote'	=>  $this->info['note'],
				'pageAction'=>  'View All',
				'pageModule'=> 'user/logs',
				'return'	=> self::returnUrl()
				
			);

            return $next($request);
        });

		
	}

	public function getIndex( Request $request )
	{
		if($this->access['is_view'] ==0){
			return redirect(url()->previous())
				->with(['message'=> 'Sorry, You are not allowed to access.','status'=>'error']);
		}
						
		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'auditID'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null($request->input('search')) ? '': '');


		
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
		$pagination->setPath('logs');
		
		
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
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('user.logs.index',$this->data);
	}	



	function getUpdate(Request $request, $id = null)
	{
	
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return redirect('login')->with('message','Sorry, You are not allowed to access.')->with('status','error');
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return redirect('login')->with('message','Sorry, You are not allowed to access.')->with('status','error');
		}				
				
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['pageAction']	= 'Edit';
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_logs'); 
			$this->data['pageAction']	= 'Add New';
		}

		$this->data['id'] = $id;
		return view('user.logs.form',$this->data);
	}	

	public function getShow( $id = null)
	{
	
		if($this->access['is_detail'] ==0) 
			return redirect('login')
				->with('message', 'Sorry, You are not allowed to access.')->with('status','error');
					
		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_logs'); 
		}
		$this->data['pageAction']	= 'View';
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('user.logs.view',$this->data);	
	}	

	function postSave( Request $request, $id =0)
	{
		
		$rules = $this->validateForm($request);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost($request);
			
			$this->model->insertRow($data , $request->input('auditID'));
			return redirect('user/logs?return='.self::returnUrl())->with('message','The record has been saved successfully!')->with('status','success');
			
		} else {

			return redirect('user/logs/update/'.$id)->with('message','The following errors occurred!')->with('status','error')
			->withErrors($validator)->withInput();
		}	
	
	}	

	public function postDelete( Request $request)
	{
		
		if($this->access['is_remove'] ==0) 
			return redirect('login')
				->with('message', 'Sorry, You are not allowed to access.')->with('status','error');
		// delete multipe rows 
		if(count($request->input('id')) >=1)
		{
			$this->model->destroy($request->input('id'));
			
			// redirect
			return redirect('user/logs')
        		->with('message', 'The record has been removed successfully!')->with('status','success'); 
	
		} else {
			return redirect('user/logs')
        		->with('message','No Item Deleted')->with('status','error');				
		}

	}			


}