@component('mail::message')
# Hello Admin

Please check following error:

Exception: {{$message}} #{{$code}}

{{$file}}: {{$line}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent