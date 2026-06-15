<?php

namespace App\Models;

use App\Models\ApprovalLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OWDD extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'o_w_d_d_s';

    protected $appends = ['doctype'];

    public function getDocTypeAttribute()
    {
        if ($this->ObjType == 17) {
            return 'Sales order';
        }

        if ($this->ObjType == 15) {
            return 'Deliveries';
        }

        if ($this->ObjType == 13) {
            return 'A/R Invoice';
        }

        if ($this->ObjType == 14) {
            return 'A/R Credit Memo';
        }

        if ($this->ObjType == 16) {
            return 'A/R Sales Return';
        }

        if ($this->ObjType == 18) {
            return 'A/P Invoice';
        }

        if ($this->ObjType == 1250000001) {
            return 'Inventory Transfer Request';
        }

        if ($this->ObjType == 1470000113) {
            return 'Purchase Request';
        }

        if ($this->ObjType == 46) {
            return 'Outgoing Payments';
        }

        if ($this->ObjType == 19) {
            return 'A/P Credit Memo';
        }

        if ($this->ObjType == 22) {
            return 'Purchase Orders';
        }

        if ($this->ObjType == 60) {
            return 'Good Issue';
        }

        if ($this->ObjType == 67) {
            return 'Inventory Transfer';
        }
    }

    public function documentowner()
    {
        return $this->belongsTo(User::class, 'OwnerID', 'USERID');
    }

    public function wdd1()
    {
        return $this->hasMany(WDD1::class, 'WddCode', 'WddCode');
    }

    public function stagecode()
    {
        return $this->hasMany(WDD1::class, 'StepCode', 'CurrStep');
    }

    public function currentstage()
    {
        return $this->wdd1->merge($this->stagecode);
    }

    public function approvalLog()
    {
        return $this->hasOne(ApprovalLog::class, 'wdd_id');
    }

    public function scopeApprovalLogPendingSync()
    {
        return $this->approvalLog()->where('SyncStatus', 0);
    }

    public function scopeApprovalLogSynced()
    {
        return $this->approvalLog()->where('SyncStatus', 1);
    }

    public function scopeApprovalLogSyncedWithErrors()
    {
        return $this->approvalLog()->where('SyncStatus', 2);
    }

    
}
