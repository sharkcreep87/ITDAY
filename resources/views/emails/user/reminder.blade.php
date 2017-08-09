@component('mail::message')
# Password Reset,

To reset your password, complete this form: {{ url('reset', array($token)) }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent