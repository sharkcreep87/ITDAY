<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Core\Client;
class ClientController extends Controller
{
    public function index()
    {
    	$rows = Client::where('user_id','!=',null)->get();
    	return view('core.oauth.index',['rows'=>$rows]);
    }

    public function create()
	{
		return view('core.oauth.create');
	}

	public function store(Request $request)
	{
		$validator =  \Validator::make($request->all(), [
            'name'=>'required|min:5|unique:oauth_clients,name',
        ]);
        if($validator->passes())
        {
        	$client = new Client();
			$client->user_id = \Auth::user()->id;
			$client->name = $request->name;
			$client->redirect = '';
			$client->personal_access_client = 0;
			$client->password_client = 0;
			$client->revoked = 0;
			$client->secret = base64_encode(hash_hmac('sha256',$request->name, 'secret', true));
			$client->save();
			return redirect('core/oauth')->with('message','Client has been saved successfully!')->with('status','success');
        }
        else
        {
        	return redirect('core/oauth')->with('message',$validator->errors()->first('name'))->with('status','error');
        }
		
	}

	public function token($id)
	{
		$client = Client::find($id);	
		$http = new \GuzzleHttp\Client;
		$response = $http->post(url('oauth/token'), [
	        'form_params' => [
	            'grant_type' => 'client_credentials',
	            'client_id' => $client->id,
	            'client_secret' => $client->secret
	        ],
	    ]);
		$json = json_decode($response->getBody());
		session()->put('access_token',$json->access_token);
		return view("core.oauth.token", ['oauth'=>$json]);
	}

	public function destroy($id)
	{
		$client = Client::find($id);
		if($client)
		{
			$client->delete($id);
			return redirect('core/oauth')->with('message','Client has been deleted successfully!')->with('status','success');
		}
		return redirect('core/oauth')->with('message', 'Not found client id.')->with('status','error');
	}
}
