<?php

namespace App\Models\DTO;

use Spatie\LaravelData\Data;

class ApprovalRequestDTO extends Data
{
    public function __construct(
        public string $WddCode,
        public string $WtmCode,
        public string $OwnerID,
        public  ?string $DocEntry, //Generate Document
        public string $ObjType,
        public string $DocDate,
        public string $CurrStep,
        public string $Status,
        public  ?string $Remarks,
        public string $UserSign,
        public string $CreateDate,
        public string $NormalTime,
        public string $IsDraft,
        public string $MaxReqr,
        public string $MaxRejReqr,
        public  ?string $SrcDocEnt,
        public string $DraftType,
        public string $DraftEntry,
        public string $BFType,
        public string $ProcessID,
        public string $ProcesStat,
        public string $StpUpdated,
    ) {
    }
}
