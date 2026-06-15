<?php

namespace App\Models\ApprovalProcess;

use App\Models\ApprovalTemplateStage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalTemplate extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'approval_templates';

    public function templatesstages(): HasMany
    {
        return $this->hasMany(ApprovalTemplateStage::class, 'template_id');
    }

    public function templatesnumberingseries(): HasMany
    {
        return $this->hasMany(ApprovalTemplatesNumberingSeries::class, 'template_id');
    }

    public function templatesusergroups(): HasMany
    {
        return $this->hasMany(ApprovalTemplatesUserGroup::class, 'template_id');
    }
}
