<?php namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\Core\Users;
use App\Models\Core\Groups;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input ; 
use Mail;

class UserController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'users';
	static $per_page	= '10';

	public function __construct()
	{
		parent::__construct();

		$this->middleware(function ($request, $next) {
            
            $this->model = new Users();
			$this->info = $this->model->makeInfo($this->module);
			$this->access = $this->model->validAccess($this->info['name']);
		
			$this->data = array(
				'pageTitle'	=> 	$this->info['title'],
				'pageNote'	=>  $this->info['note'],
				'pageAction'=>  'View All Users',
				'pageModule'=> 'user',
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
						
		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
		$filter .= " AND tb_users.group_id >= '".\Auth::user()->group_id."'" ;

		
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
		$pagination->setPath('user');
		
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
		return view('user.index',$this->data);
	}

	function getUpdate(Request $request, $id = null)
	{
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return redirect('/')->with('message','Sorry, You are not allowed to access.')->with('status','error');
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return redirect('/')->with('message','Sorry, You are not allowed to access.')->with('status','error');
		}				
				
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['pageAction'] =  'Edit User';
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_users'); 
			$this->data['pageAction'] =  'Add New User';
		}

		$this->data['id'] = $id;
		return view('user.form',$this->data);
	}	

	public function getShow( $id = null)
	{
	
		if($this->access['is_detail'] ==0) 
			return redirect('/')
				->with('message', 'Sorry, You are not allowed to access.')->with('status','error');
					
		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_users'); 
		}
		$this->data['pageAction'] =  'View User';
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('user.view',$this->data);	
	}	

	function postSave( Request $request, $id =0)
	{
		
		$rules = $this->validateForm($request);
		if($request->input('id') =='')
		{
			$rules['password'] 				= 'required|between:6,12';
			$rules['password_confirmation'] = 'required|between:6,12';
			$rules['email'] 				= 'required|email|unique:tb_users';
			$rules['username'] 				= 'required|alpha_num||min:2|unique:tb_users';
			
		} else {
			if($request->input('password') !='')
			{
				$rules['password'] 				='required|between:6,12';
				$rules['password_confirmation'] ='required|between:6,12';			
			}
		}
		if(!is_null($request->file('avatar'))) $rules['avatar'] = 'mimes:jpg,jpeg,png,gif,bmp';

		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost($request);
			if($request->input('id') =='')
			{
				$data['password'] = \Hash::make($request->input('password'));
			} else {
				if($request->input('password') !='')
				{
					$data['password'] = \Hash::make($request->input('password'));
				} else {
					unset($data['password']);
				}
			}
					
			
			$id = $this->model->insertRow($data , $request->input('id'));

			if(!is_null($request->file('avatar')))
			{
				$updates = array();
				$file = $request->file('avatar'); 
				$destinationPath = './uploads/users/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = $filename;
				$uploadSuccess = $request->file('avatar')->move($destinationPath, $newfilename);				 
				if( $uploadSuccess ) {
				    $updates['avatar'] = $newfilename; 
				} 
				$this->model->insertRow($updates , $id );
			}	

			if(!is_null($request->input('apply')))
			{
				$return = 'user/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'user?return='.self::returnUrl();
			}
			
			return redirect($return)->with('message','The record has been saved successfully!')->with('status','success');
			
		} else {

			return redirect('user/update/'.$id)->with('message','The following errors occurred!')->with('status','error')
			->withErrors($validator)->withInput();
		}	
	
	}	

	public function postDelete( Request $request)
	{
		
		if($this->access['is_remove'] ==0) 
			return redirect('/')
				->with('message', 'Sorry, You are not allowed to access.')->with('status','error');
		// delete multipe rows 
		if(count($request->input('ids')) >=1)
		{
			$this->model->destroy($request->input('ids'));
			
			// redirect
			return redirect('user')
        		->with('message', 'The record has been removed successfully!')->with('status','success'); 
	
		} else {
			return redirect('user')
        		->with('message','No Item Deleted')->with('status','error');				
		}

	}

	public function getSearch( $mode = 'native')
	{

		$this->data['tableForm'] 	= $this->info['config']['forms'];	
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['searchMode'] = 'native';
		$this->data['pageUrl']		= url('user');
		return view('user.search',$this->data);
	
	}	

	function getBlast()
	{
		$this->data = array(
			'groups'	=> Groups::all(),
			'pageTitle'	=> 'Blast Email',
			'pageNote'	=> 'Send email to users'
		);	
		return view('user.blast',$this->data);		
	}

	function postDoblast( Request $request)
	{

		$rules = array(
			'subject'		=> 'required',
			'message'		=> 'required|min:10',
			'groups'		=> 'required',				
		);	
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) 
		{	

			if(!is_null($request->input('groups')))
			{
				$count = 0;
				$groups = $request->input('groups');
				for($i=0; $i<count($groups); $i++)
				{
					if($request->input('uStatus') == 'all')
					{

						$users = \DB::table('tb_users')->where('group_id','=',$groups[$i])->get();
					} else {
						$users = \DB::table('tb_users')->where('active','=',$request->input('uStatus'))->where('group_id','=',$groups[$i])->get();
					}
					

					foreach($users as $row)
					{
						$data['note'] 	= $request->input('message');
						$data['row']		= $row;
						$data['to']			= $row->email;
						$data['subject']	= $request->input('subject');

						
						if(env('APP_MAIL') =='swift')
						{ 
							Mail::send('user.email', $data, function ($message) use ($data) {
					    		$message->to($data['to'])->subject($data['subject']);
					    	});


					    } else {
					    	$message = view('user.email',$data);
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From: '.env('APP_NAME').' <'.env('APP_EMAIL').'>' . "\r\n";
								mail($data['to'], $data['subject'], $message, $headers);

					    }							
						
						++$count;					
					} 
					
				}
				return redirect('user/blast')->with('message','Total '.$count.' Message has been sent')->with('status','success');

			}
			return redirect('user/blast')->with('message','No Message has been sent')->with('status','info');
			

		} else {

			return redirect('user/blast')->with('message', 'The following errors occurred')->with('status','error')
			->withErrors($validator)->withInput();

		}	
	}

}