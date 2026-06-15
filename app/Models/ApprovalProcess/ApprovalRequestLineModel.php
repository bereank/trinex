<?php

namespace App\Models\ApprovalProcess;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalRequestLineModel extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'approval_request_line_models';

    public function approvalrequest(): BelongsTo
    {
        return $this->belongsTo(ApprovalRequestModel::class, 'WddCode');
    }

    public function approvalstage(): BelongsTo
    {
        return $this->belongsTo(ApprovalStage::class, 'StepCode');
    }

    public function authorizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
