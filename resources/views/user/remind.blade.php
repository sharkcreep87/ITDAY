@extends('user.master')
@section('content')
<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="" action="{{url('remember')}}" method="post" data-parsley-validate>
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
        <a href="{{url('login')}}" id="back-btn" class="btn green btn-outline">Back</a>
        <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
</form>
<!-- END FORGOT PASSWORD FORM -->
@endsection