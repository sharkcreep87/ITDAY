@extends('user.master')
@section('content')
<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="" action="{{url('reset/'.$verCode)}}" method="post" data-parsley-validate>
    {{csrf_field()}}
    <h3 class="font-green">Reset Password ?</h3>
    <p> Enter your new password below. </p>
    @if (session('message'))
        <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{ session('message') }}
        </div>
    @endif
    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" value="{{old('password')}}" required />
        @if ($errors->has("password"))
        <span class="help-block">
            <strong>{{ $errors->first("password") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="password_confirmation" value="{{old('password_confirmation')}}" required />
        @if ($errors->has("password_confirmation"))
        <span class="help-block">
            <strong>{{ $errors->first("password_confirmation") }}</strong>
        </span>
        @endif
    </div>
    <div class="form-actions">
        <a href="{{url('login')}}" id="back-btn" class="btn green btn-outline">Back</a>
        <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
</form>
<!-- END FORGOT PASSWORD FORM -->
@endsection