<?php

namespace App\Services\Shared;

use BereanK\Integrator\QueryManager\QueryExcuter;
use BereanK\Integrator\Services\ConfigProviderService;
use BereanK\Integrator\Services\HanaDBConnector;

class CommonsService
{
    public function getDocTypeAttribute($ObjType)
    {
        if ($ObjType == 17) {
            return 'Sales order';
        }

        if ($ObjType == 15) {
            return 'Deliveries';
        }

        if ($ObjType == 13) {
            return 'A/R Invoice';
        }

        if ($ObjType == 14) {
            return 'A/R Credit Memo';
        }

        if ($ObjType == 16) {
            return 'A/R Sales Return';
        }

        if ($ObjType == 1250000001) {
            return 'Inventory Transfer Request';
        }

        if ($ObjType == 1470000113) {
            return 'Purchase Request';
        }
    }

    public function getLinkedDatabases()
    {
        return explode(',', env('LINKED_DATABASES'));
    }

 

    public function headerFields()
    {

        $STRING_TYPE = 2;
        $INT_TYPE = 1;
        return  [

            [
                'Label' => 'Series Name',
                'Column' => 'SeriesName',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],
            [
                'Label' => 'Documber Number',
                'Column' => 'DocNum',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],
            [
                'Label' => 'BP Code',
                'Column' => 'CardCode',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],

            [
                'Label' => 'BP Name',
                'Column' => 'CardName',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],
            
            [
                'Label' => 'BP Balance',
                'Column' => 'Balance',
                'Size' => 2,
                'Type'  =>   $INT_TYPE,
            ],
            [
                'Label' => 'Vendor Ref. No',
                'Column' => 'NumAtCard',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],
            [
                'Label' => 'Branch',
                'Column' => 'U_Branch',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],
            [
                'Label' => 'Invoice FDN',
                'Column' => 'U_InvoiceNumber',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],
            [
                'Label' => 'Supplier TIN NO.',
                'Column' => 'LicTradNum',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],
            [
                'Label' => 'DocDate',
                'Column' => 'DocDate',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],
            [
                'Label' => 'DocDueDate',
                'Column' => 'DocDueDate',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],
            [
                'Label' => 'DocTotal',
                'Column' => 'DocTotal',
                'Size' => 2,
                'Type'  => $INT_TYPE,
            ],
            [
                'Label' => 'DocTotalFC',
                'Column' => 'DocTotalFC',
                'Size' => 2,
                'Type'  =>  $STRING_TYPE,
            ],

          
            [
                'Label' => 'Owner',
                'Column' => 'Owner',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Cash Customer',
                'Column' => 'U_CashName',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Phone Number',
                'Column' => 'U_CashNo',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],

            [
                'Label' => 'Petty Cash/Purchase Request',
                'Column' => 'U_PCash',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],

            [
                'Label' => 'Sale Type',
                'Column' => 'U_SaleType',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],

            [
                'Label' => 'Type Of Purchase',
                'Column' => 'U_TypePur',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Letter Of Credit',
                'Column' => 'U_LC',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Bank Conf One',
                'Column' => 'U_Bank',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Bank Conf  Two',
                'Column' => 'U_BankB',
                'Size' => 2,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Banked Aamount',
                'Column' => 'U_BankedAamount',
                'Size' => 2,
                'Type'  => $INT_TYPE,
            ],
            [
                'Label' => 'Comments',
                'Column' => 'Comments',
                'Size' => 12,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'WT Amount',
                'Column' => 'WTAmnt',
                'Size' => 2,
                'Type'  =>  $INT_TYPE,
            ],

            [
                'Label' => 'WT Rate',
                'Column' => 'WTRate',
                'Size' => 2,
                'Type'  =>  $INT_TYPE,
            ],
        ];
    }

    public function rowFields()
    {

        $STRING_TYPE = 2;
        $INT_TYPE = 1;


        return  [
            [
                'Label' => 'Item Code',
                'Column' => 'ItemCode',
                'SortID' => 1,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Item Name',
                'Column' => 'Dscription',
                'SortID' => 2,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'G\L Account',
                'Column' => 'AcctCode',
                'SortID' => 3,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'G\L Account Name',
                'Column' => 'AcctName',
                'SortID' => 4,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'From Whse',
                'Column' => 'FromWhsCod',
                'SortID' => 5,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Whse',
                'Column' => 'WhsCode',
                'SortID' => 6,
                'Type'  => $STRING_TYPE,
            ],

            [
                'Label' => 'Qty',
                'Column' => 'Quantity',
                'SortID' => 7,
                'Type'  => $INT_TYPE,
            ],

            [
                'Label' => 'Uom Code',
                'Column' => 'UomCode',
                'SortID' => 10,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Price',
                'Column' => 'Price',
                'SortID' => 11,
                'Type'  => $INT_TYPE,
            ],
            [
                'Label' => 'Disc %',
                'Column' => 'DiscPrcnt',
                'SortID' => 12,
                'Type'  => $INT_TYPE,
            ],
            [
                'Label' => 'Line Total',
                'Column' => 'LineTotal',
                'SortID' => 13,
                'Type'  => $INT_TYPE,
            ],

            [
                'Label' => 'Tax Code',
                'Column' => 'VatGroup',
                'SortID' => 14,
                'Type'  => $STRING_TYPE,
            ],

            [
                'Label' => 'WTax Liable',
                'Column' => 'WtLiable',
                'SortID' => 15,
                'Type'  => $STRING_TYPE,
            ],

            [
                'Label' => 'Gross Profit After Disc',
                'Column' => 'GrssProfit',
                'SortID' => 17,
                'Type'  => $INT_TYPE,
            ],
            [
                'Label' => 'Location',
                'Column' => 'Location',
                'SortID' => 18,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Project',
                'Column' => 'Project',
                'SortID' => 19,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Country Of Origin',
                'Column' => 'CountryOrg',
                'SortID' => 20,
                'Type'  =>$STRING_TYPE,
            ],
            [
                'Label' => 'Department',
                'Column' => 'Department',
                'SortID' => 21,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Product Line',
                'Column' => 'ProductLine',
                'SortID' => 22,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Staff',
                'Column' => 'StaffName',
                'SortID' => 24,
                'Type'  => $STRING_TYPE,
            ],
            [
                'Label' => 'Vehicle',
                'Column' => 'Vehicle',
                'SortID' => 25,
                'Type'  => $STRING_TYPE,
            ],
        ];
    }
}
