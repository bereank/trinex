<?php

namespace App\Models\ApprovalProcess;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalStageApprover extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'approval_stage_approvers';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
