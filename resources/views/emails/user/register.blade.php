@component('mail::message')
# Hello {{$firstname.' '.$lastname}},

Thank you for joining with us.<br>
Your account Info...<br>
Email : {{$email}}<br>
Password : {{$password}}<br>

Please follow link for activation<br>
@component('mail::button', ['url' => url('activation?code='.$code.'&redirectUri='.$redirect), 'color'=>'green'])
Active Account
@endcomponent

If the link have not working , copy and paste bellow link
{{url('activation?code='.$code.'&redirectUri='.$redirect)}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
