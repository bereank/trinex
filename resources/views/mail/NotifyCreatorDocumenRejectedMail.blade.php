@component('mail::message')
# Hello {{$draftDocument->createdBy->name}}

<br>
Your document has been rejected.

### Document Comment: 

**{{$draftDocument->Comments}}**


#### Approval Status Report

@component('mail::table')
| Stage| Authorizer| Status | Remarks |
|:---: |:--------:|:-----:| :----:|
@foreach($approvalLogs as $approvalLog)
| {{$approvalLog->approvalstage->Name}} | {{$approvalLog->authorizer->name}} | {{$approvalLog->StatusNormal}} | {{$approvalLog->Remarks}} |
@endforeach
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
