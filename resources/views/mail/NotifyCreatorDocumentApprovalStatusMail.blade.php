@component('mail::message')
# Hello {{$draftDocument->createdBy->name}}

<br>
Your document has been fully approved by all parties.



Document Number: **{{$draftDocument->id}}**

External Reference : **{{$draftDocument->ExtRefDocNum}}**

[Print Document]({{ url('/v1/expense/view/'.$draftDocument->client_id.'/'.$draftDocument->id.'') }})

Thanks,<br>
{{ config('app.name') }}
@endcomponent
