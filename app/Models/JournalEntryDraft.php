<?php

namespace App\Models;

use App\Models\ApprovalProcess\ApprovalRequestModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JournalEntryDraft extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'exchange_rate' => 'decimal:6',
        'posting_date' => 'date:Y-m-d',
        'due_date' => 'date:Y-m-d',
        'document_date' => 'date:Y-m-d',
        'lines' => 'array',
        'attachments' => 'array',
    ];

      public function createdby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserSign');
    }

    public function requestedby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserSign');
    }

    
    public function approvalrequest(): HasOne
    {
        return $this->hasOne(ApprovalRequestModel::class, 'DraftEntry');
    }

}
