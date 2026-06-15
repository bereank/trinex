<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDatabase extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'company_databases';
}
