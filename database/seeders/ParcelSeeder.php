<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Backend\Parcel;
use App\Enums\DeliveryTime;

class ParcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        for ($i=0; $i < 2; $i++) {

            $parcel                         = new Parcel();

            $parcel->merchant_id            = 1;
            $parcel->merchant_shop_id       = 1;
            $parcel->pickup_address         = "Mirpur-02";
            $parcel->pickup_phone           = "01478523698";
            $parcel->customer_name          = "Abdullah ". $i;
            $parcel->customer_phone         = "01478523655";
            $parcel->customer_address       = "Mirpur-10";
            $parcel->invoice_no             = "123654";
            $parcel->category_id            = 1;
            $parcel->weight                 = 5;
            $parcel->delivery_type_id       = 1;
            $parcel->packaging_id           = 3;
            $parcel->cash_collection        = 500;
            $parcel->selling_price          = 500;
            $parcel->liquid_fragile_amount  = 20;
            $parcel->packaging_amount       = 30;
            $parcel->delivery_charge        = 50;
            $parcel->cod_charge             = 1;
            $parcel->cod_amount             = 5;
            $parcel->vat                    = 10;
            $parcel->vat_amount             = 5.5;
            $parcel->total_delivery_amount  = 110.5;
            $parcel->current_payable        = 389.5;
            $parcel->tracking_id            = 'RX'.substr(strtotime(date('H:i:s')),1).'C1'. $i;
            $parcel->note                   = "Test parcel";

            // Pickup & Delivery Time
            if(date('H') < DeliveryTime::LAST_TIME){
                $parcel->pickup_date      = date('Y-m-d');
                $parcel->delivery_date    = date('Y-m-d');
            }
            else{
                $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));;
            }

            $parcel->save();
        }
    }
}
