<?php

namespace App\Models;

use App\Models\CompanyDatabase;
use Illuminate\Database\Eloquent\Model;
use App\Models\ApprovalProcess\ApprovalTemplate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDatabase extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'user_databases';

    public $with = ['dbdetails'];

    public function documentowner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function dbdetails()
    {
        return $this->belongsTo(CompanyDatabase::class, 'client_id', 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function defaulttemplate():BelongsTo
    {
        return $this->belongsTo(ApprovalTemplate::class, 'default_template_id');
    }
}
