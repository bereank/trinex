<?php

namespace App\Models\ApprovalProcess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalRequestModel extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'approval_request_models';

    public function approvalrequeslinemodel(): HasMany
    {
        return $this->hasMany(ApprovalRequestLineModel::class, 'WddCode');
    }
}
