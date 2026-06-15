<?php

namespace App\Models\ApprovalProcess;

use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalTemplatesUserGroup extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'approval_templates_user_groups';

    public function usergroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'group_id');
    }

    public function approvaltemplate(): BelongsTo
    {
        return $this->belongsTo(approvaltemplate::class, 'template_id');
    }
}
