<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $guarded = ['id'];

    protected $table = 'o_t_p_s';

    protected $dates = [
        'updated_at',
        'created_at',
        'two_factor_expires_at',
    ];
}
