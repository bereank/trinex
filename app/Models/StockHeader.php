<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockHeader extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = 'stocks_header';

    public function stock():HasOne
    {
        return $this->hasOne(Stock::class, 'id');
    }

    
}
