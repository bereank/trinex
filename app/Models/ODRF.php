<?php

namespace App\Models;

use App\Models\ApprovalProcess\ApprovalRequestModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ODRF extends Model
{
    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'o_d_r_f_s';

    public function rows(): HasMany
    {
        return $this->hasMany(DRF1::class, 'DocEntry');
    }

    public function createdby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserSign');
    }

    public function requestedby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserSign');
    }

    public function approvalrequest(): HasOne
    {
        return $this->hasOne(ApprovalRequestModel::class, 'DraftEntry');
    }

    public function scopeIsOpened($query)
    {
        $query->where('DocStatus', 'O');

        return $query;
    }
}
