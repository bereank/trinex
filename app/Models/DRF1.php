<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DRF1 extends Model
{
    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'd_r_f1_s';

    public function document(): BelongsTo
    {
        return $this->belongsTo(ODRF::class, 'DocEntry');
    }
}
