<?php

namespace App\Actions;

use App\Models\OWDD;
use App\Models\WDD1;
use App\Models\ApprovalLog;
use App\Models\UserDatabase;


class GetObjectTypesAction
{

    public function __construct()
    {
    }

    public function handle(): array
    {


        $data = [
            [
                "ObjType" => 17,
                "name" => "Sales order"
            ],
            [
                "ObjType" => 15,
                "name" => "Deliveries"
            ],
            [
                "ObjType" => 13,
                "name" => "A/R Invoice"
            ],
            [
                "ObjType" => 14,
                "name" => "A/R Credit Memo"
            ],
            [
                "ObjType" => 16,
                "name" => "A/R Sales Return"
            ],
            [
                "ObjType" => 17,
                "name" => "Sales  order"
            ],
            [
                "ObjType" => 18,
                "name" => "A/P Invoice"
            ],
            [
                "ObjType" => 1250000001,
                "name" => "Inventory Transfer Request"
            ],
            [
                "ObjType" => 1470000113,
                "name" => "Purchase Request"
            ],
            [
                "ObjType" => 19,
                "name" => "A/P Credit Memo"
            ],
            [
                "ObjType" => 67,
                "name" => "Inventory Transfer"
            ],
            [
                "ObjType" => 22,
                "name" => "Purchase Order"
            ],

            [
                "ObjType" => 46,
                "name" => "Outgoing Payments"
            ],

            [
                "ObjType" => 22,
                "name" => "Purchase order"
            ],
            [
                "ObjType" => 59,
                "name" => "Good Receipt"
            ],
            [
                "ObjType" => 60,
                "name" => "Good Issue"
            ],
        ];

        return $data;
    }
}
