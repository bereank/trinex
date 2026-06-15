<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WDD1 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'w_d_d1_s';
}
