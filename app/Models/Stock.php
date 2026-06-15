<?php

namespace App\Models;


use App\Models\StockHeader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = 'stocks';


    public function stock_head():BelongsTo
    {
        return $this->belongsTo(StockHeader::class, 'DocEntry');
    }
}
