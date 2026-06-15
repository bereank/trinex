@component('mail::message')
# Hi {{ $user['name'] }}

<br>
Your Express Way OTP is: 

##  {{$otp}} 

It will expires in 2 minutes;


Thanks,<br>
{{ config('app.name') }}
@endcomponent
