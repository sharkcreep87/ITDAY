<div class="form col-xs-12 col-md-12">
<!-- Id  -->
<div class="form-group {{ $errors->has('Id') ? 'has-error' : '' }}  " >
	<label for="Id" class=" control-label col-xs-12 col-md-4 text-left"> Id <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='Id' id='Id' value='{{ $row['Id'] }}' required   class='form-control ' />
  		@if ($errors->has("Id"))
	<span class="help-block">
		<strong>{{ $errors->first("Id") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

{!! Form::hidden('username', $row['username']) !!}
<!-- Password  -->
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}  " >
	<label for="Password" class=" control-label col-xs-12 col-md-4 text-left"> Password <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<textarea name='password' rows='5' id='password' class='form-control ' required  >{{ $row['password'] }}</textarea>
  		@if ($errors->has("password"))
	<span class="help-block">
		<strong>{{ $errors->first("password") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Fname  -->
<div class="form-group {{ $errors->has('fname') ? 'has-error' : '' }}  " >
	<label for="Fname" class=" control-label col-xs-12 col-md-4 text-left"> Fname <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<textarea name='fname' rows='5' id='fname' class='form-control ' required  >{{ $row['fname'] }}</textarea>
  		@if ($errors->has("fname"))
	<span class="help-block">
		<strong>{{ $errors->first("fname") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Address  -->
<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}  " >
	<label for="Address" class=" control-label col-xs-12 col-md-4 text-left"> Address <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<textarea name='address' rows='5' id='address' class='form-control ' required  >{{ $row['address'] }}</textarea>
  		@if ($errors->has("address"))
	<span class="help-block">
		<strong>{{ $errors->first("address") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Email  -->
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}  " >
	<label for="Email" class=" control-label col-xs-12 col-md-4 text-left"> Email <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<textarea name='email' rows='5' id='email' class='form-control ' required  >{{ $row['email'] }}</textarea>
  		@if ($errors->has("email"))
	<span class="help-block">
		<strong>{{ $errors->first("email") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Referedby  -->
<div class="form-group {{ $errors->has('referedby') ? 'has-error' : '' }}  " >
	<label for="Referedby" class=" control-label col-xs-12 col-md-4 text-left"> Referedby <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='referedby' id='referedby' value='{{ $row['referedby'] }}' required   class='form-control ' />
  		@if ($errors->has("referedby"))
	<span class="help-block">
		<strong>{{ $errors->first("referedby") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Ipaddress  -->
<div class="form-group {{ $errors->has('ipaddress') ? 'has-error' : '' }}  " >
	<label for="Ipaddress" class=" control-label col-xs-12 col-md-4 text-left"> Ipaddress <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='ipaddress' id='ipaddress' value='{{ $row['ipaddress'] }}' required   class='form-control ' />
  		@if ($errors->has("ipaddress"))
	<span class="help-block">
		<strong>{{ $errors->first("ipaddress") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Mobile  -->
<div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}  " >
	<label for="Mobile" class=" control-label col-xs-12 col-md-4 text-left"> Mobile <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='mobile' id='mobile' value='{{ $row['mobile'] }}' required   class='form-control ' />
  		@if ($errors->has("mobile"))
	<span class="help-block">
		<strong>{{ $errors->first("mobile") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Active  -->
<div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}  " >
	<label for="Active" class=" control-label col-xs-12 col-md-4 text-left"> Active <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='active' id='active' value='{{ $row['active'] }}' required   class='form-control ' />
  		@if ($errors->has("active"))
	<span class="help-block">
		<strong>{{ $errors->first("active") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Doj  -->
<div class="form-group {{ $errors->has('doj') ? 'has-error' : '' }}  " >
	<label for="Doj" class=" control-label col-xs-12 col-md-4 text-left"> Doj <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='doj' id='doj' value='{{ $row['doj'] }}' required   class='form-control ' />
  		@if ($errors->has("doj"))
	<span class="help-block">
		<strong>{{ $errors->first("doj") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Country  -->
<div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}  " >
	<label for="Country" class=" control-label col-xs-12 col-md-4 text-left"> Country <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<textarea name='country' rows='5' id='country' class='form-control ' required  >{{ $row['country'] }}</textarea>
  		@if ($errors->has("country"))
	<span class="help-block">
		<strong>{{ $errors->first("country") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Tamount  -->
<div class="form-group {{ $errors->has('tamount') ? 'has-error' : '' }}  " >
	<label for="Tamount" class=" control-label col-xs-12 col-md-4 text-left"> Tamount <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='tamount' id='tamount' value='{{ $row['tamount'] }}' required   class='form-control ' />
  		@if ($errors->has("tamount"))
	<span class="help-block">
		<strong>{{ $errors->first("tamount") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Payment  -->
<div class="form-group {{ $errors->has('payment') ? 'has-error' : '' }}  " >
	<label for="Payment" class=" control-label col-xs-12 col-md-4 text-left"> Payment <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='payment' id='payment' value='{{ $row['payment'] }}' required   class='form-control ' />
  		@if ($errors->has("payment"))
	<span class="help-block">
		<strong>{{ $errors->first("payment") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Signupcode  -->
<div class="form-group {{ $errors->has('signupcode') ? 'has-error' : '' }}  " >
	<label for="Signupcode" class=" control-label col-xs-12 col-md-4 text-left"> Signupcode <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<textarea name='signupcode' rows='5' id='signupcode' class='form-control ' required  >{{ $row['signupcode'] }}</textarea>
  		@if ($errors->has("signupcode"))
	<span class="help-block">
		<strong>{{ $errors->first("signupcode") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Level  -->
<div class="form-group {{ $errors->has('level') ? 'has-error' : '' }}  " >
	<label for="Level" class=" control-label col-xs-12 col-md-4 text-left"> Level <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='level' id='level' value='{{ $row['level'] }}' required   class='form-control ' />
  		@if ($errors->has("level"))
	<span class="help-block">
		<strong>{{ $errors->first("level") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Pcktaken  -->
<div class="form-group {{ $errors->has('pcktaken') ? 'has-error' : '' }}  " >
	<label for="Pcktaken" class=" control-label col-xs-12 col-md-4 text-left"> Pcktaken <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='pcktaken' id='pcktaken' value='{{ $row['pcktaken'] }}' required   class='form-control ' />
  		@if ($errors->has("pcktaken"))
	<span class="help-block">
		<strong>{{ $errors->first("pcktaken") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Launch  -->
<div class="form-group {{ $errors->has('launch') ? 'has-error' : '' }}  " >
	<label for="Launch" class=" control-label col-xs-12 col-md-4 text-left"> Launch <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='launch' id='launch' value='{{ $row['launch'] }}' required   class='form-control ' />
  		@if ($errors->has("launch"))
	<span class="help-block">
		<strong>{{ $errors->first("launch") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Expiry  -->
<div class="form-group {{ $errors->has('expiry') ? 'has-error' : '' }}  " >
	<label for="Expiry" class=" control-label col-xs-12 col-md-4 text-left"> Expiry <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='expiry' id='expiry' value='{{ $row['expiry'] }}' required   class='form-control ' />
  		@if ($errors->has("expiry"))
	<span class="help-block">
		<strong>{{ $errors->first("expiry") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Bankname  -->
<div class="form-group {{ $errors->has('bankname') ? 'has-error' : '' }}  " >
	<label for="Bankname" class=" control-label col-xs-12 col-md-4 text-left"> Bankname <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='bankname' id='bankname' value='{{ $row['bankname'] }}' required   class='form-control ' />
  		@if ($errors->has("bankname"))
	<span class="help-block">
		<strong>{{ $errors->first("bankname") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Accountname  -->
<div class="form-group {{ $errors->has('accountname') ? 'has-error' : '' }}  " >
	<label for="Accountname" class=" control-label col-xs-12 col-md-4 text-left"> Accountname <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='accountname' id='accountname' value='{{ $row['accountname'] }}' required   class='form-control ' />
  		@if ($errors->has("accountname"))
	<span class="help-block">
		<strong>{{ $errors->first("accountname") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Accountno  -->
<div class="form-group {{ $errors->has('accountno') ? 'has-error' : '' }}  " >
	<label for="Accountno" class=" control-label col-xs-12 col-md-4 text-left"> Accountno <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='accountno' id='accountno' value='{{ $row['accountno'] }}' required   class='form-control ' />
  		@if ($errors->has("accountno"))
	<span class="help-block">
		<strong>{{ $errors->first("accountno") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Accounttype  -->
<div class="form-group {{ $errors->has('accounttype') ? 'has-error' : '' }}  " >
	<label for="Accounttype" class=" control-label col-xs-12 col-md-4 text-left"> Accounttype <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='accounttype' id='accounttype' value='{{ $row['accounttype'] }}' required   class='form-control ' />
  		@if ($errors->has("accounttype"))
	<span class="help-block">
		<strong>{{ $errors->first("accounttype") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Ifsccode  -->
<div class="form-group {{ $errors->has('ifsccode') ? 'has-error' : '' }}  " >
	<label for="Ifsccode" class=" control-label col-xs-12 col-md-4 text-left"> Ifsccode <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='ifsccode' id='ifsccode' value='{{ $row['ifsccode'] }}' required   class='form-control ' />
  		@if ($errors->has("ifsccode"))
	<span class="help-block">
		<strong>{{ $errors->first("ifsccode") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Getpayment  -->
<div class="form-group {{ $errors->has('getpayment') ? 'has-error' : '' }}  " >
	<label for="Getpayment" class=" control-label col-xs-12 col-md-4 text-left"> Getpayment <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='getpayment' id='getpayment' value='{{ $row['getpayment'] }}' required   class='form-control ' />
  		@if ($errors->has("getpayment"))
	<span class="help-block">
		<strong>{{ $errors->first("getpayment") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Renew  -->
<div class="form-group {{ $errors->has('renew') ? 'has-error' : '' }}  " >
	<label for="Renew" class=" control-label col-xs-12 col-md-4 text-left"> Renew <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='renew' id='renew' value='{{ $row['renew'] }}' required   class='form-control ' />
  		@if ($errors->has("renew"))
	<span class="help-block">
		<strong>{{ $errors->first("renew") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

<!-- Payoff  -->
<div class="form-group {{ $errors->has('payoff') ? 'has-error' : '' }}  " >
	<label for="Payoff" class=" control-label col-xs-12 col-md-4 text-left"> Payoff <span class='asterix'> * </span></label>
	<div class="col-xs-12 col-md-7">
  		<input type='text' name='payoff' id='payoff' value='{{ $row['payoff'] }}' required   class='form-control ' />
  		@if ($errors->has("payoff"))
	<span class="help-block">
		<strong>{{ $errors->first("payoff") }}</strong>
	</span>
	@endif
  		 	</div> 	<div class="col-xs-12 col-md-1">
 		
 	</div>
</div>

</div>
