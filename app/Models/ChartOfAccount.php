<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChartOfAccount extends Model
{
    
    protected $guarded = ['id'];

    protected $table = 'chart_of_accounts';


}
