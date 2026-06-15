@component('mail::message')
# Hello 


Outgoing Payment draft for Purchase request:  **{{$draftDocument->ExtRefDocNum}}**  as been created in SAP by **{{$draftDocument->Requester}}**, Personel Name **{{$draftDocument->CardName}}**,Phone Number **{{$draftDocument->Address}}**, Details are as follows:

Document Draft Entry: **{{$draftDocument->BaseEntry}}**



Thanks,<br>
{{ config('app.name') }}
@endcomponent
