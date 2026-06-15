<?php

namespace App\Models\ApprovalProcess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalUserWorkflow extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'approval_user_workflows';
}
