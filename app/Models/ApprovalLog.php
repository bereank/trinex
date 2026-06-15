<?php

namespace App\Models;

use App\Models\OWDD;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'approval_logs';


    public function approvalrequest(): BelongsTo
    {
        return $this->belongsTo(OWDD::class, 'wdd_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function scopePendingSync($query)
    {
        return $query->where('SyncStatus', '!=', 1);
    }

    public function scopeApprovedAndSynced($query, int $clientId, int $user_id)
    {
        return $query->where('SyncStatus', 1)->where('client_id', $clientId)->where('user_id', $user_id);
    }
}
