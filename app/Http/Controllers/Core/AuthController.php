<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Core\Users;
use App\Mail\Register;
use App\Mail\Reminder;
class AuthController extends Controller
{
	public $module = 'users';
	public function __construct()
	{
		$this->model = new Users();
		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['name'], env('APP_GROUP', 1));
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

	public function create()
    {
    	if(env('APP_REGIST')=='true') {
    		return view('user.register');
    	}
    	return redirect('/login')->with(['message'=>'Not allow you access to register.','status'=>'error']);
    }

	public function register(Request $request)
	{
    	$validator =  \Validator::make($request->all(), [
            'first_name'=>'required',
            'last_name'=>'required',
            'username'=>'required|min:5|unique:tb_users,username',
			'email'=>'required|email|unique:tb_users',
			'password'=>'required|min:6|confirmed',
			'password_confirmation'=>'required|min:6'
        ]);
        if($validator->passes())
        {
        	$code = rand(10000,10000000);
        	$data = $this->validatePost($request);
        	$data['password'] = bcrypt($request->input('password'));
        	$data['activation'] = $code;
        	$data['group_id'] = env('APP_GROUP',1);
        	$data['active'] = env('APP_ACTIVATION') == 'auto' ? '1' : '0';
        	$id = $this->model->insertRow($data , NULL);
			
			$data = array(
				'sub'		=> "[ " .env('APP_NAME','API Toolz')." ] REGISTRATION ",
				'firstname'	=> $request->input('first_name') ? $request->input('first_name') : $request->input('username'),
				'lastname'	=> $request->input('last_name') ,
				'email'		=> $request->input('email') ,
				'password'	=> $request->input('password') ,
				'code'		=> $code,
				'redirect'  => $request->header('origin').'/login',
			);

			if(env('APP_ACTIVATION') == 'confirmation')
			{ 

				$to = $request->input('email');
				if(env('APP_MAIL') =='swift')
				{ 
					\Mail::to($to)->send(new Register($data));
				}  else {
					$subject = "[ " .env('APP_NAME','API Toolz')." ] REGISTRATION ";
					$message = view('user.emails.registration', $data);
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.env('APP_NAME').' <'.env('APP_EMAIL').'>' . "\r\n";
					mail($to, $subject, $message, $headers);	
				}

				$message = "Thanks for registering! . Please check your inbox and follow activation link";
								
			} elseif(env('APP_ACTIVATION')=='manual') {
				$message = "Thanks for registering! . We will validate you account before your account active";
			} else {
   			 	$message = "Thanks for registering! . Your account is active now ";         
			}
			if($request->ajax() || $request->is('api/*'))
			{
				return response()->json($message);
			}
			return redirect('login')->with(['message'=>$message,'status'=>'success']);
        }else{
        	if($request->ajax() == true || $request->is('api/*'))
			{
				return response()->json($validator->errors(), 400);
			}
        	return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }
	}

	public function activate( Request $request  )
	{
		if(\Auth::check())
		{
			\Auth::logout();
			\Session::flush();
		}

		$num = $request->input('code');
		$redirect = $request->input('redirectUri') ? $request->input('redirectUri') : url('login');
		if($num =='')
		{
			if($request->ajax() || $request->is('api/*'))
			{
				return response()->json('Invalid Activation Code!',400);
			}
			$redirect .= '?message=Invalid Activation Code!&status=error';
			return redirect($redirect)->with(['message'=>'Invalid Activation Code!','status'=>'error']);
		}

		$user =  User::where('activation','=',$num)->first();
		if ($user)
		{
			$user->active = 1;
			$user->activation = '';
			$user->update();
			if($request->ajax() || $request->is('api/*'))
			{
				return response()->json('Your account is active now!');
			}
			$redirect .= '?message=Your account is active now!&status=success';
			return redirect($redirect)->with(['message'=>'Your account is active now!','status'=>'success']);
		} else {
			if($request->ajax() || $request->is('api/*'))
			{
				return response()->json('Invalid Activation Code!',400);
			}
			$redirect .= '?message=Invalid Activation Code!&status=error';
			return redirect($redirect)->with(['message'=>'Invalid Activation Code!','status'=>'error']);
		}
	}

	public function login()
    {
    	if(\Auth::check())
		{
			return redirect(url()->previous())->with(['message'=>'Youre already login.','status'=>'success']);
		} else {
			$count = User::count();
			return View('user.login',['count'=>$count]);
		}	
    }

    public function signin( Request $request) {
		$rules = array(
			'email'=>'required|email',
			'password'=>'required',
		);		
		$validator = \Validator::make($request->all(), $rules);
		if ($validator->passes()) {	

			$remember = (!is_null($request->get('remember')) ? 'true' : 'false' );
			if (\Auth::attempt(array('email'=>$request->input('email'), 'password'=> $request->input('password') ), $remember )) {
				if(\Auth::check())
				{
					$user = User::find(\Auth::user()->id); 
					if($user->active =='0')
					{
						// inactive 
						if($request->ajax() == true || $request->is('api/*'))
						{
							return response()->json('Your account is not active.', 400);
						} else {
							\Auth::logout();
							return redirect('login')->with(['message'=>'Your account is not active.','status'=>'error']);
						}
						
					} else if($user->active=='2')
					{
						if($request->ajax() == true || $request->is('api/*'))
						{
							return response()->json('Your bccount is blocked.', 400);
						} else {
							// BLocked users
							\Auth::logout();
							return redirect('login')->with(['message'=>'Your account is bLocked.','status'=>'error']);
						}
					} else {
						$user->last_login = date("Y-m-d H:i:s");
						$user->update();
						$redirect = \Auth::user()->group_id > 1 ? env('APP_REDIRECT') : '/';
						if($request->ajax() == true || $request->is('api/*'))
						{
							return response()->json($user);
						} else {
							return redirect()->intended($redirect);
						}
					}			
				}			
				
			} else {

				if($request->ajax() == true || $request->is('api/*'))
				{
					return response()->json('Your username/password combination was incorrect',400);
				} else {

					return redirect('login')
						->with(['message'=>'Your username/password combination was incorrect.','status'=>'error'])
						->withInput();					
				}
			}
		} else {

				if($request->ajax() == true || $request->is('api/*'))
				{
					return response()->json($validator->errors(), 400);
				} else {
					return redirect('login')
						->with(['message' => 'The following  errors occurred.','status'=>'error'])
						->withErrors($validator)->withInput();
				}	
		

		}	
	}

	public function logout() {
		if(\Auth::check())
		{
			\Auth::logout();
			\Session::flush();
		}
		return redirect('login')->with(['message'=>'Your are now logged out!', 'status'=>'success']);
	}

	public function getRemember()
	{
		return view('user.remind');
	}	

	public function postRemember(Request $request)
	{
		$rules = array(
			'email'=>'required|email'
		);	
		
		$validator = \Validator::make($request->all(), $rules);
		if ($validator->passes()) {	
	
			$user =  User::where('email','=',$request->input('email'))->first();
			if($user)
			{
				$data = array('token'=>$request->input('_token'));	
				$to = $request->input('email');
				$data['sub'] = "[ " .env('APP_NAME')." ] REQUEST PASSWORD RESET "; 	
				if(env('APP_MAIL') =='swift')
				{ 
					\Mail::to($to)->send(new Reminder($data));
				}  else {

					$message = view('user.emails.auth.reminder', $data);
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.env('APP_NAME').' <'.env('APP_EMAIL').'>' . "\r\n";
					mail($to, $subject, $message, $headers);	
				}					
			
				$user->reminder = $request->input('_token');
				$user->update();

				return redirect('login')->with(['message'=>'Please check your email.','status'=>'success']);	
				
			} else {
				return redirect('remember')->with(['message'=>'Cant find your email address.','status'=>'error'])->withInput();
			}

		}  else {
			return redirect('remember')->with(['message'=> 'The following errors occurred.','status'=>'error'])->withErrors($validator)->withInput();
		}	 
	}	
	
	public function getReset( $token = '')
	{
		if(\Auth::check()) return redirect('/');

		$user = User::where('reminder','=',$token)->first();
		if($user)
		{
			$data['verCode']= $token;
			return view('user.reset',$data);
		} else {
			return redirect('login')->with('message','Cant find your reset code.');
		}
		
	}	
	
	public function postReset( Request $request , $token = '')
	{
		$rules = array(
			'password'=>'required|alpha_num|between:6,12|confirmed',
			'password_confirmation'=>'required|alpha_num|between:6,12'
			);		
		$validator = \Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			
			$user =  User::where('reminder','=',$token)->first();
			if($user)
			{
				$user->reminder = '';
				$user->password = bcrypt($request->input('password'));
				$user->update();			
			}
			return redirect('login')->with(['message'=>'The password has been successfully saved!','status'=>'success']);
		} else {
			return redirect('reset/'.$token)->with(['message'=>'The following errors occurred.','status'=>'success'])->withErrors($validator)->withInput();
		}	
	
	}

	public function getProfile($id = '', Request $request)
	{
		if($id == '') $id = \Auth::user()->id;

		$user = User::where('id', $id)->first();
		if($user)
		{
			if($request->ajax() || $request->is('api/*'))
			{
				return response()->json($user);
			}
			return view('user.profile', ['user'=>$user]);
		}
		if($request->ajax() || $request->is('api/*'))
		{
			return response()->json('Invalid user id value.', 400);
		}
		return redirect(url()->previous())->with(['message'=>'Invalid user id value.','status'=>'error']);
	}

	public function postProfile($id = '', Request $request)
	{
		$rules = [];	
		if($id == '') $id = \Auth::user()->id;
		if($request->ajax() || $request->is('api/*'))
		{
			if($request->input('email') && $request->input('email') != User::where('id', $id)->value('email')){
				$rules['email'] = 'required|email|unique:tb_users';
			}
		}else{
			if($request->input('email') && $request->input('email') != \Auth::user()->email)
			{
				$rules['email'] = 'required|email|unique:tb_users';
			}
		}	

		if($request->file('avatar'))
		{ 
			$rules['avatar'] = 'mimes:jpg,jpeg,png,gif,bmp';
		}
				
		$validator = \Validator::make($request->all(), $rules);

		if ($validator->passes()) {
			$data = $this->validatePost($request);
			if($id =='')
			{
				$data['password'] = bcrypt($request->input('password'));
			} else {
				if($request->input('password') !='')
				{
					$data['password'] = bcrypt($request->input('password'));
				} else {
					unset($data['password']);
				}
			}

			$id = $this->model->insertRow($data , $id);
			
			if($request->file('avatar'))
			{
				$file = $request->file('avatar'); 
				$destinationPath = './uploads/users/';
				$filename = date('YmdHis');
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$filename = $filename.'.png';
				$uploadSuccess = $request->file('avatar')->move($destinationPath, $filename);				 
				if( $uploadSuccess ) {
					@unlink($destinationPath.$user->avatar);
				    $updates['avatar'] = $filename; 
				} 
				$this->model->insertRow($updates , $id );
				
			}

			if($request->ajax() || $request->is('api/*'))
			{
				$user = Users::find($id);
				return response()->json($user);
			}
			return redirect('user/profile')->with(['message'=>'Profile has been saved!','status'=>'success']);
		} else {
			if($request->ajax() || $request->is('api/*'))
			{
				return response()->json($validator->errors(), 400);
			}
			return redirect('user/profile')->with(['message'=>'The following errors occurred','status'=>'error'])->withErrors($validator)->withInput();
		}	
	
	}
	
	public function postPassword($id = '', Request $request)
	{
		$rules = array(
			'password'=>'required|between:6,12|confirmed',
			'password_confirmation'=>'required|between:6,12'
		);

		$validator = \Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			if($id == '') $id = \Auth::user()->id;
			$user = User::find($id);
			$user->password = bcrypt($request->input('password'));
			$user->save();
			if($request->ajax() || $request->is('api/*'))
			{
				return response()->json('Password has been saved.!');
			}
			return redirect('user/profile')->with(['message'=>'Password has been saved.!','status'=>'success']);
		} else {
			if($request->ajax() || $request->is('api/*'))
			{
				return response()->json($validator->errors(), 400);
			}
			return redirect('user/profile#tab_1_3')->with(['message'=>'The following errors occurred.','status'=>'error'])->withErrors($validator)->withInput();
		}	
	
	}
}
