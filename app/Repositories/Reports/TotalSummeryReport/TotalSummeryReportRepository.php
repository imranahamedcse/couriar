<?php
namespace App\Repositories\Reports\TotalSummeryReport;

use App\Enums\AccountHeads;

use App\Models\Backend\Account;
use App\Models\Backend\BankTransaction;
use App\Models\Backend\Expense;
use App\Models\Backend\Parcel;
use App\Models\CashReceivedFromDeliveryman;
use Carbon\Carbon;
use Database\Seeders\ParcelSeeder;
use Illuminate\Support\Facades\Auth;

class TotalSummeryReportRepository implements TotalSummeryReportInterface {

        public function parcelTotalSummeryReports($request){

            $parcels =   Parcel::with('parcelEvent')->where(function( $query ) use ( $request ) {
                if($request->parcel_date) {
                    $date = explode('To', $request->parcel_date);
                    if(is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();

                        $query->whereBetween('created_at', [$from, $to]);
                    }
                }

                if($request->hub_id) {
                    $query->where('hub_id',$request->hub_id);

                }

                if($request->parcel_merchant_id) {
                    $query->where(['merchant_id' => $request->parcel_merchant_id]);
                }

            })->orderBy('id','asc')->get();
            return $parcels;
    }

    public function commissionDeliveryman($request){

            $commissionDeliveryMan  =   Expense::where('account_head_id',5)->where(function( $query ) use ( $request ) {
                if($request->parcel_date) {
                    $date = explode('To', $request->parcel_date);
                    if(is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();

                        $query->whereBetween('date', [$from, $to]);
                    }
                }

            })->orderBy('id','asc')->get();
            return $commissionDeliveryMan;
    }

    public function cashReceivedDeliveryman($request){

            $cashReceivedDeliveryMan  =   CashReceivedFromDeliveryman::where(function( $query ) use ( $request ) {
                if($request->parcel_date) {
                    $date = explode('To', $request->parcel_date);
                    if(is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();

                        $query->whereBetween('date', [$from, $to]);
                    }
                }
                if($request->hub_id) {
                    $query->where('hub_id',$request->hub_id);

                }

            })->orderBy('id','asc')->get();
            return $cashReceivedDeliveryMan;
    }

    public function accounts($request){

        $accounts  =   Account::where(function( $query ) use ( $request ) {
            if($request->parcel_date) {
                $date = explode('To', $request->parcel_date);
                if(is_array($date)) {
                    $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                    $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();

                    $query->whereBetween('updated_at', [$from, $to]);
                }
            }


        })->orderBy('id','asc')->get();
        return $accounts;
    }



    public function incomeExpense($type){
        return BankTransaction::where('type',$type)->orderByDesc('id')->sum('amount');
    }

}
