<?php

namespace App\Models;

use App\Models\ApprovalProcess\ApprovalStage;
use App\Models\ApprovalProcess\ApprovalTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalTemplateStage extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'approval_template_stages';

    public function approvalstage(): BelongsTo
    {
        return $this->belongsTo(ApprovalStage::class, 'approval_stage_id');
    }

    public function approvaltemplate(): BelongsTo
    {
        return $this->belongsTo(ApprovalTemplate::class, 'template_id');
    }
}
