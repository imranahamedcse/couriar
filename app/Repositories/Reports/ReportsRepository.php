<?php
namespace App\Repositories\Reports;

use App\Enums\AccountHeads;
use App\Enums\ApprovalStatus;
use App\Enums\ParcelStatus;
use App\Enums\StatementType;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\BankTransaction;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\DeliverymanStatement;
use App\Models\Backend\Expense;
use App\Models\Backend\Hub;
use App\Models\Backend\HubStatement;
use App\Models\Backend\Merchant;
use App\Models\backend\MerchantStatement;
use App\Models\Backend\Parcel;
use App\Models\Backend\Payment;
use App\Models\Backend\Payroll\SalaryGenerate;
use App\Models\Backend\Salary;
use App\Models\CashReceivedFromDeliveryman;
use App\Models\User;
use App\Repositories\Reports\ReportsInterface;
use Carbon\Carbon;
use Database\Seeders\ParcelSeeder;
use function Symfony\Component\Mime\Header\all;

class ReportsRepository implements ReportsInterface {

    public function parcelReports($request){
            $userHubID = $request->hub_id;

            if(!blank($userHubID)){
              $parcels =   Parcel::with('parcelEvent')->where('hub_id',$userHubID)->orderBy('id','asc')->where(function( $query ) use ( $request ) {

                    if($request->parcel_date) {
                        $date = explode('To', $request->parcel_date);
                        if(is_array($date)) {
                            $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                            $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                            $query->whereBetween('created_at', [$from, $to]);
                        }
                    }

                    if($request->parcel_status) {
                        $query->whereIn('status',$request->parcel_status);

                    }

                    if($request->parcel_merchant_id) {
                        $query->where(['merchant_id' => $request->parcel_merchant_id]);
                    }

                })->orderBy('id','asc')->get();
                return $parcels->groupBy('status');

            }else{
               $parcels=  Parcel::with('parcelEvent')->orderBy('id','asc')->where(function( $query ) use ( $request ) {

                    if($request->parcel_date) {
                        $date = explode('To', $request->parcel_date);
                        if(is_array($date)) {
                            $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                            $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                            $query->whereBetween('created_at', [$from, $to]);
                        }

                    }

                    if($request->parcel_status) {
                        $query->whereIn('status',$request->parcel_status);
                    }


                    if($request->parcel_merchant_id) {
                        $query->where(['merchant_id' => $request->parcel_merchant_id]);
                    }

                })->get();
                return $parcels->groupBy('status');

            }
        }


    public function parcelWiseProfitReports($request){
            $userHubID = $request->hub_id;

            if(!blank($userHubID)){
              return  Parcel::with('parcelEvent')->where('hub_id',$userHubID)->orderBy('id','asc')->where(function( $query ) use ( $request ) {

                    if($request->parcel_date) {
                        $date = explode('To', $request->parcel_date);
                        if(is_array($date)) {
                            $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                            $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                            $query->whereBetween('created_at', [$from, $to]);
                        }
                    }

                    if($request->parcel_tracking_id) {
                        $query->whereIn('id',$request->parcel_tracking_id);
                    }


                    if($request->parcel_merchant_id) {
                        $query->where(['merchant_id' => $request->parcel_merchant_id]);
                    }

                })->orderBy('id','asc')->get();


            }else{
               return   Parcel::with('parcelEvent')->orderBy('id','asc')->where(function( $query ) use ( $request ) {

                    if($request->parcel_date) {
                        $date = explode('To', $request->parcel_date);
                        if(is_array($date)) {
                            $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                            $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                            $query->whereBetween('created_at', [$from, $to]);
                        }

                    }

                    if($request->parcel_tracking_id) {
                        $query->whereIn('id',$request->parcel_tracking_id);
                    }

                    if($request->parcel_merchant_id) {
                        $query->where(['merchant_id' => $request->parcel_merchant_id]);
                    }

                })->get();

            }
        }


        //salary reports
    public function salaryReports($request){


            $salaryPayment  = Salary::with('user')->where(function($query)use($request){
                if($request->salary_date) {
                        $date = explode('To', $request->salary_date);
                        if(is_array($date)) {
                            $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                            $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                            $query->whereBetween('created_at', [$from, $to]);
                        }
                }

                if($request->month){
                    $query->where('month',$request->month);
                }

                if($request->user_id):
                    $query->whereIn('user_id',$request->user_id);
                endif;

            })->orderBy('month','asc')->get();
            $salary         = SalaryGenerate::with('user')->where(function($query)use($request){
            if($request->salary_date) {
                $date = explode('To', $request->salary_date);
                if(is_array($date)) {
                    $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                    $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                    $query->whereBetween('created_at', [$from, $to]);
                }
            }

            if($request->month){
                $query->where('month',$request->month);
            }

            if($request->user_id):
                $query->whereIn('user_id',$request->user_id);
            endif;

        })->orderBy('month','asc')->get();

            $data['salaryPayment']   = $salaryPayment->groupBy('month');
            $data['salary']          = $salary->groupBy('month');
          return $data;
        }


    public function salaryReportsPrint($request){

            $data=[];
            $data['salaries'] = Salary::whereIn('id',$request->salary_ids)->get()->groupBy('month');

            return $data;
        }


        //merchant hub delivery man reports

    public function MHDreports($request){
            if($request->parcel_date) {
                $date = explode('To', $request->parcel_date);
                if(is_array($date)) {
                    $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                    $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                }
            }

            $data = [];
            if($request->user_type == 1):
                // $parcels                       =  Parcel::where('merchant_id',$request->merchant_id)->whereBetween('created_at', [$from, $to])->pluck('id');
                // $data['total_parcel']          =  Parcel::where('merchant_id',$request->merchant_id)->count();
                // $data['parcels']               =  Parcel::where('merchant_id',$request->merchant_id)->whereBetween('created_at', [$from, $to])->get();
                // $data['merchant']              =  Merchant::find($request->merchant_id);
                // $data['total_paid_to_merchant']=  Payment::where('merchant_id',$request->merchant_id)->where('status',ApprovalStatus::PROCESSED)->sum('amount');
                // $data['merchantReports']       =  MerchantStatement::with('parcel')->whereIn('parcel_id',$parcels)->orWhere('merchant_id',$request->merchant_id)->whereBetween('created_at', [$from, $to])->get();

                // //print need
                // $data['parcel_ids']            = '';
                // $data['merchantStatment_ids']  = '';
                // foreach ($data['parcels']->pluck('id') as $id) {
                //     $data['parcel_ids']        = $id.','. $data['parcel_ids'];
                // }
                // foreach ($data['merchantReports']->pluck('id') as $id) {
                //     $data['merchantStatment_ids'] = $id.','.$data['merchantStatment_ids'];
                // }
                // //end print



            elseif($request->user_type == 2):

                $data['hub']                   =  Hub::find($request->hub_id);
                $data['hub_statements']        =  HubStatement::where('hub_id',$request->hub_id)->get();

                //print need
                $data['hub_statement_ids']            = '';
                foreach ($data['hub_statements']->pluck('id') as $id) {
                    $data['hub_statement_ids']        = $id.','. $data['hub_statement_ids'];
                }
                //end print


            elseif($request->user_type == 3):
                $data['deliveryman']           =  DeliveryMan::find($request->delivery_man_id);
                $data['deliveryman_statements']=  DeliverymanStatement::where('delivery_man_id',$request->delivery_man_id)->whereBetween('created_at', [$from, $to])->get();

                //print need
                    $data['deliveryman_statement_ids']            = '';
                    foreach ($data['deliveryman_statements']->pluck('id') as $id) {
                        $data['deliveryman_statement_ids']        = $id.','. $data['deliveryman_statement_ids'];
                    }

                //end print

            else:
                return [];
            endif;
            return $data;


        }


    public function MHDprint($request){
        $data=[];

        // if($request->user_type == 1)://merchant

        //     $parcel_ids  = [];
        //     foreach (explode(',',$request->parcel_ids) as  $id) {
        //         if($id !== ""):
        //         $parcel_ids [] = $id;
        //         endif;
        //     }

        //     $merchant_statement_ids = [];
        //     foreach (explode(',',$request->merchant_statement_ids) as  $id) {
        //         if($id !== ""):
        //         $merchant_statement_ids [] = $id;
        //         endif;
        //     }

        //     $data['total_parcel']          =  $request->total_parcel;
        //     $data['parcels']               =  Parcel::where('merchant_id',$request->merchant_id)->whereIn('id',$parcel_ids)->get();
        //     $data['merchant']              =  Merchant::find($request->merchant_id);
        //     $data['total_paid_to_merchant']=  $request->total_paid_to_merchant;
        //     $data['merchantReports']       =  MerchantStatement::with('parcel')->whereIn('parcel_id',$parcel_ids)->orWhere('merchant_id',$request->merchant_id)->get();

        // elseif($request->user_type == 2)://hub

        //     $hub_statement_ids = [];
        //     foreach (explode(',',$request->hub_statement_ids) as  $id) {
        //         if($id !== ""):
        //         $hub_statement_ids [] = $id;
        //         endif;
        //     }


        //     $data['hub']                   =  Hub::find($request->hub_id);
        //     $data['hub_statements']        =  HubStatement::whereIn('hub_id',$hub_statement_ids)->get();

        // else
        if($request->user_type == 3):

            $deliveryman_statement_ids = [];
            foreach (explode(',',$request->deliveryman_statement_ids) as  $id) {
                if($id !== ""):
                $deliveryman_statement_ids [] = $id;
                endif;
            }

            $data['deliveryman']           =  DeliveryMan::find($request->delivery_man_id);
            $data['deliveryman_statements']=  DeliverymanStatement::where('delivery_man_id',$request->delivery_man_id)->whereIn('id',$deliveryman_statement_ids)->get();

        endif;

    return $data;
    }

    public function MerchantExport($request){
            dd('kasd');
    }




    //merchant reports

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

                if($request->user_type == 2){

                    if($request->hub_id) {
                        $query->where('hub_id',$request->hub_id);
                    }else{
                        $hubs=Hub::all()->pluck('id');
                        $ids=[];
                        foreach ($hubs as  $id) {
                            $ids[]=$id;
                        }
                        $query->whereIn('hub_id',$ids);
                    }

                }

                if($request->parcel_merchant_id) {
                    $query->where(['merchant_id' => $request->parcel_merchant_id]);
                }
                if($request->merchant_id) {
                    $query->where(['merchant_id' => $request->merchant_id]);
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

                if($request->delivery_man_id) {
                    $query->where(['delivery_man_id' => $request->delivery_man_id]);
                }

            })->orderBy('id','asc')->get();
            return $commissionDeliveryMan;
    }


    public function totalHubIncome($request){
        $hubincome  =   HubStatement::where('type',AccountHeads::INCOME)->where(function( $query ) use ( $request ) {
            if($request->parcel_date) {
                $date = explode('To', $request->parcel_date);
                if(is_array($date)) {
                    $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                    $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();

                    $query->whereBetween('date', [$from, $to]);
                }
            }

            if($request->hub_id) {
                $query->where(['hub_id' => $request->hub_id]);
            }

        })->orderBy('id','asc')->get();
        return $hubincome;
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

                if($request->delivery_man_id) {
                    $query->where(['delivery_man_id' => $request->delivery_man_id]);
                }

            })->orderBy('id','asc')->get();
            return $cashReceivedDeliveryMan;
    }


    public function incomeExpense($type){
        return BankTransaction::where('type',$type)->orderByDesc('id')->sum('amount');
    }

    public function hubincomeExpense($hub_id,$type){
        return BankTransaction::where('hub_id',$hub_id)->where('type',$type)->orderByDesc('id')->sum('amount');
    }




    //delivery man reports

    public function deliverymanreportParcels($request){

            $parcels_id   = $this->deliverymanStatement($request)->pluck('parcel_id');
            $ids=[];
            foreach ($parcels_id as $id) {
                $ids[]=$id;
            }

            $parcels =   Parcel::whereIn('id',$ids)->whereIn('status',[parcelStatus::DELIVERED,parcelStatus::PARTIAL_DELIVERED,parcelStatus::RECEIVED_WAREHOUSE,parcelStatus::RETURN_ASSIGN_TO_MERCHANT])->where(function( $query ) use ( $request ) {
                if($request->parcel_date) {
                    $date = explode('To', $request->parcel_date);
                    if(is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();

                        $query->whereBetween('created_at', [$from, $to]);
                    }
                }



            })->orderBy('id','asc')->get();

        return $parcels;
    }
        public function deliverymanStatement($request){
            $deliveryStatement =   DeliverymanStatement::where(function( $query ) use ( $request ) {
                if($request->parcel_date) {
                    $date = explode('To', $request->parcel_date);
                    if(is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();

                        $query->whereBetween('created_at', [$from, $to]);
                    }
                }

                if($request->delivery_man_id) {
                    $query->where(['delivery_man_id' => $request->delivery_man_id]);
                }

            })->orderBy('id','asc')->get();

            return $deliveryStatement;
        }
}
