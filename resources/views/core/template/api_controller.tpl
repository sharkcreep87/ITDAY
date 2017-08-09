<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{controller};
use Illuminate\Http\Request;
use Validator; 


class {controller}APIController extends Controller {

	public $module = '{class}';

	public function __construct()
	{
		
		$this->model = new {controller}();
		{masterdetailmodel}
		$this->info = $this->model->makeInfo($this->module);	
		
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$sort = (!is_null($request->input('sort')) ? $request->input('sort') : '');
		$order = (!is_null($request->input('order')) ? $request->input('order') : '');
		$search = (!is_null($request->input('search')) ? $request->input('search') : '{search}');
		$filter = '';	
		if($search != '')
		{
			$search = $this->buildSearch('maps');
			$filter = $search['param'];
		} 

		$page = $request->input('page', '1');
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : '' ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> 1,
		);

		$results = $this->model->getRows( $params );
		$rows = [];
		foreach ($results['rows'] as $key => $row) {
			$rows[] = \SiteHelpers::formatAPI($row, $this->info['config']);
		}
		return response()->json($rows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->validateForm($request, $request->input('{key}'));
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost($request);
				
			$id = $this->model->insertRow($data , $request->input('{key}'));
			{masterdetailapisave}
			// Insert logs into database
			if($request->input('{key}') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New data wit id['.$id.'] has been inserted!');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with id['.$id.'] has been updated!');
			}
			{email}
			
			return response()->json($this->model->getRow($id));
			
		} else {

			return response()->json($validator->errors()->all(), 400);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = $this->model->getRow($id);
		if($row)
		{
			return response()->json(\SiteHelpers::formatAPI($row, $this->info['config'], true));
		} else {
			return response()->json('Record Not Found !', 400);					
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = $this->validateForm($request, $id);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes() && count($this->model->getRow($id)) > 0) {


			$data = $this->validatePost($request);
				
			$id = $this->model->insertRow($data , $id);
			{masterdetailapisave}
			// Insert logs into database
			if($request->input('{key}') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New data with id['.$id.'] has been inserted!');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with id['.$id.'] has been in updated!');
			}

			$response = $this->model->getRow($id);
			return response()->json($response);
			
		} else {

			return response()->json($validator->errors()->all(), 400);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		if({controller}::find($id))
		{
			$this->model->destroy($id);
			
			\SiteHelpers::auditTrail( new Request , "ID : ". $id. " has been removed!");

			return response()->json('The record has been removed successfully!');
	
		} else {
			return response()->json('Record Not Found !', 400);					
		}
    }
}