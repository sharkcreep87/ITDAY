@extends('user.master')
@section('content')
<!-- BEGIN LOGIN FORM -->
<form class="login-form" action="{{url('login')}}" method="post" data-parsley-validate>
    {{csrf_field()}}
    <h3 class="form-title font-green">Sign In</h3>
    @if (session('message'))
        <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{ session('message') }}
        </div>
    @else
        @if(env('APP_REGIST')=='true' && $count <= 1)
        <div class="alert alert-danger">
            Please login to your application with admin right account. If you don't have admin right account, <a href="javascript:;" id="register-btn">Sign Up Now</a>.
        </div>
        @endif
    @endif
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" value="{{old('email')}}" required />
        @if ($errors->has("email"))
        <span class="help-block">
            <strong>{{ $errors->first("email") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" required />
        @if ($errors->has("password"))
        <span class="help-block">
            <strong>{{ $errors->first("password") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-actions">
        <button type="submit" class="btn green uppercase">Login</button>
        <label class="rememberme check mt-checkbox mt-checkbox-outline icheck">
            <input type="checkbox" name="remember" value="1" />Remember
            <span></span>
        </label>
        <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
    </div>
    @if(env('APP_REGIST')=='true')
    <div class="create-account">
        <p>
            <a href="javascript:;" id="register-btn" class="uppercase">Create an account</a>
        </p>
    </div>
    @endif
</form>
<!-- END LOGIN FORM -->
<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="forget-form" action="{{url('remember')}}" method="post" data-parsley-validate>
    {{csrf_field()}}
    <h3 class="font-green">Forget Password ?</h3>
    <p> Enter your e-mail address below to reset your password. </p>
    @if (session('message'))
        <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{ session('message') }}
        </div>
    @endif
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" value="{{old('email')}}" required />
        @if ($errors->has("email"))
        <span class="help-block">
            <strong>{{ $errors->first("email") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-actions">
        <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
        <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
</form>
<!-- END FORGOT PASSWORD FORM -->
<!-- BEGIN REGISTRATION FORM -->
<form class="register-form" action="{{'register'}}" method="post" data-parsley-validate>
    {{csrf_field()}}
    <h3 class="font-green">Sign Up</h3>
    <p class="hint"> Enter your personal details below: </p>
    @if (session('message'))
        <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{ session('message') }}
        </div>
    @endif
    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">First Name</label>
        <input class="form-control placeholder-no-fix" type="text" placeholder="First Name" name="first_name" value="{{old('first_name')}}" required />
        @if ($errors->has("first_name"))
        <span class="help-block">
            <strong>{{ $errors->first("first_name") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Last Name</label>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Last Name" name="last_name" value="{{old('last_name')}}" required />
        @if ($errors->has("last_name"))
        <span class="help-block">
            <strong>{{ $errors->first("last_name") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <input class="form-control placeholder-no-fix" type="email" placeholder="Email" name="email" value="{{old('email')}}" required />
        @if ($errors->has("email"))
        <span class="help-block">
            <strong>{{ $errors->first("email") }}</strong>
        </span>
        @endif
    </div>
    <p class="hint"> Enter your account details below: </p>
    <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" value="{{old('username')}}" required />
        @if ($errors->has("username"))
        <span class="help-block">
            <strong>{{ $errors->first("username") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" value="{{old('password')}}" required/>
        @if ($errors->has("password"))
        <span class="help-block">
            <strong>{{ $errors->first("password") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="password_confirmation" required/>
        @if ($errors->has("password_confirmation"))
        <span class="help-block">
            <strong>{{ $errors->first("password_confirmation") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('tnc') ? 'has-error' : '' }} margin-top-20 margin-bottom-20">
        <label class="mt-checkbox mt-checkbox-outline icheck">
            <input type="checkbox" name="tnc" required/> I agree to the
            <a href="javascript:;">Terms of Service </a> &
            <a href="javascript:;">Privacy Policy </a>
            <span></span>
        </label>
        @if ($errors->has("tnc"))
        <span class="help-block">
            <strong>{{ $errors->first("tnc") }}</strong>
        </span>
        @endif
        <div id="register_tnc_error"> </div>
    </div>
    <div class="form-actions">
        <button type="button" id="register-back-btn" class="btn green btn-outline">Back</button>
        <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
</form>
<!-- END REGISTRATION FORM -->
@endsection
@section('script')
<script type="text/javascript">
    var Login = function() {
        var r = function() {
                jQuery("#forget-password").click(function() {
                    jQuery(".login-form").hide(), jQuery(".forget-form").show()
                }), 
                jQuery("#back-btn").click(function() {
                    jQuery(".login-form").show(), jQuery(".forget-form").hide()
                })
            };
            i = function() {
                jQuery("#register-btn").click(function() {
                    jQuery(".login-form").hide(), jQuery(".register-form").show()
                }), jQuery("#register-back-btn").click(function() {
                    jQuery(".login-form").show(), jQuery(".register-form").hide()
                })
            };
        return {
            init: function() {
                r(), i()
            }
        }
    }();
    jQuery(document).ready(function() {
        Login.init()
    });
</script>
@endsection