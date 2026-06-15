@component('mail::message')
# Hello

<br>
{{$draftDocument->createdBy->name}} has requested you to review and sign the document  


**{{$draftDocument->Comments}}**


[View Document]({{ url('/v1/expense/view/'.$draftDocument->client_id.'/'.$draftDocument->id.'') }})

Thanks,<br>
{{ config('app.name') }}
@endcomponent
