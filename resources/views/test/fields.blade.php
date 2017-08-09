<div class="form col-xs-12 col-md-12">
<!-- Id  -->
<div class="form-group {{ $errors->has('id') ? 'has-error' : '' }}  " >
	<label for="Id" class=" control-label col-xs-12 col-md-4 text-left"> Id <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='id' id='id' value='{{ $row['id'] }}' required   class='form-control ' />
  		@if ($errors->has("id"))
	<span class="help-block">
		<strong>{{ $errors->first("id") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Group Id  -->
<div class="form-group   " >
	<label for="Group Id" class=" control-label col-xs-12 col-md-4 text-left"> Group Id </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='group_id' id='group_id' value='{{ $row['group_id'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Username  -->
<div class="form-group   " >
	<label for="Username" class=" control-label col-xs-12 col-md-4 text-left"> Username </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='username' id='username' value='{{ $row['username'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Password  -->
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}  " >
	<label for="Password" class=" control-label col-xs-12 col-md-4 text-left"> Password <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='password' id='password' value='{{ $row['password'] }}' required   class='form-control ' />
  		@if ($errors->has("password"))
	<span class="help-block">
		<strong>{{ $errors->first("password") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Email  -->
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}  " >
	<label for="Email" class=" control-label col-xs-12 col-md-4 text-left"> Email <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='email' id='email' value='{{ $row['email'] }}' required   class='form-control ' />
  		@if ($errors->has("email"))
	<span class="help-block">
		<strong>{{ $errors->first("email") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Staff Id  -->
<div class="form-group {{ $errors->has('staff_id') ? 'has-error' : '' }}  " >
	<label for="Staff Id" class=" control-label col-xs-12 col-md-4 text-left"> Staff Id <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='staff_id' id='staff_id' value='{{ $row['staff_id'] }}' required   class='form-control ' />
  		@if ($errors->has("staff_id"))
	<span class="help-block">
		<strong>{{ $errors->first("staff_id") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Phone  -->
<div class="form-group   " >
	<label for="Phone" class=" control-label col-xs-12 col-md-4 text-left"> Phone </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='phone' id='phone' value='{{ $row['phone'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- First Name  -->
<div class="form-group   " >
	<label for="First Name" class=" control-label col-xs-12 col-md-4 text-left"> First Name </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='first_name' id='first_name' value='{{ $row['first_name'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Last Name  -->
<div class="form-group   " >
	<label for="Last Name" class=" control-label col-xs-12 col-md-4 text-left"> Last Name </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='last_name' id='last_name' value='{{ $row['last_name'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Avatar  -->
<div class="form-group   " >
	<label for="Avatar" class=" control-label col-xs-12 col-md-4 text-left"> Avatar </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='avatar' id='avatar' value='{{ $row['avatar'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Active  -->
<div class="form-group   " >
	<label for="Active" class=" control-label col-xs-12 col-md-4 text-left"> Active </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='active' id='active' value='{{ $row['active'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Login Attempt  -->
<div class="form-group   " >
	<label for="Login Attempt" class=" control-label col-xs-12 col-md-4 text-left"> Login Attempt </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='login_attempt' id='login_attempt' value='{{ $row['login_attempt'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Last Login  -->
<div class="form-group   " >
	<label for="Last Login" class=" control-label col-xs-12 col-md-4 text-left"> Last Login </label>
	<div class="col-xs-12 col-md-7">
  		<div class="input-group">
	<input  type='text' name='last_login' id='last_login' value='{{ $row['last_login'] }}'    class='form-control datetime ' data-date-format='yyyy-mm-dd h:i:s' />
	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>

  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Reminder  -->
<div class="form-group   " >
	<label for="Reminder" class=" control-label col-xs-12 col-md-4 text-left"> Reminder </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='reminder' id='reminder' value='{{ $row['reminder'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Activation  -->
<div class="form-group   " >
	<label for="Activation" class=" control-label col-xs-12 col-md-4 text-left"> Activation </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='activation' id='activation' value='{{ $row['activation'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Remember Token  -->
<div class="form-group   " >
	<label for="Remember Token" class=" control-label col-xs-12 col-md-4 text-left"> Remember Token </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='remember_token' id='remember_token' value='{{ $row['remember_token'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Last Activity  -->
<div class="form-group   " >
	<label for="Last Activity" class=" control-label col-xs-12 col-md-4 text-left"> Last Activity </label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='last_activity' id='last_activity' value='{{ $row['last_activity'] }}'    class='form-control ' />
  		  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

</div>
