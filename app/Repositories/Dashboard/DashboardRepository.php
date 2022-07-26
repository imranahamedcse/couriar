<?php
namespace App\Repositories\Dashboard;

use App\Enums\AccountHeads;
use App\Enums\Status;
use App\Models\Backend\Account;
use App\Models\Backend\BankTransaction;
use App\Models\Backend\CourierStatement;
use App\Models\Backend\DeliverymanStatement;
use App\Models\Backend\Expense;
use App\Models\Backend\Income;
use App\Models\backend\MerchantStatement;
use App\Models\Backend\Parcel;
use App\Models\Backend\Payroll\SalaryGenerate;
use App\Models\Backend\Salary;
use App\Repositories\Dashboard\DashboardInterface;
use Carbon\Carbon;

class DashboardRepository implements DashboardInterface {

    public function FromTo($request){

        if($request->days     == 'today'):
            $startDate                      = Carbon::today()->format('Y-m-d');//today date
            $endDate                        = Carbon::today()->format('Y-m-d'); // today date
            $subDays                        = Carbon::parse(trim($startDate))->startOfDay()->toDateTimeString();//from
            $todayDate                      = Carbon::parse(trim($endDate))->endOfDay()->toDateTimeString();//to

        elseif($request->days     == 'week'):
            $subDays                        = Carbon::parse(Carbon::today()->subDays(7)->format('Y-m-d'))->startOfDay()->toDateTimeString(); // from today to 7 days previus date
            $todayDate                      = Carbon::parse(Carbon::today()->format('Y-m-d'))->endOfDay()->toDateTimeString();//to today date

        elseif($request->days     == '15days'):
            $subDays                        = Carbon::parse(Carbon::today()->subDays(15)->format('Y-m-d'))->startOfDay()->toDateTimeString(); //from today to 15days previus date
            $todayDate                      = Carbon::parse(Carbon::today()->format('Y-m-d'))->endOfDay()->toDateTimeString();//to today date
        elseif($request->days == 'month'):
            $subDays                        = Carbon::parse(Carbon::today()->subDays(30)->format('Y-m-d'))->startOfDay()->toDateTimeString(); //from  today to 30 days previus date
            $todayDate                      = Carbon::parse(Carbon::today()->format('Y-m-d'))->endOfDay()->toDateTimeString();//to today date
        elseif($request->days == 'yesterday'):
            $subDays                        = Carbon::parse(Carbon::today()->subDays(1)->format('Y-m-d'))->startOfDay()->toDateTimeString(); // yesterday
            $todayDate                      = Carbon::parse(Carbon::today()->subDays(1)->format('Y-m-d'))->endOfDay()->toDateTimeString(); // yesterday

        elseif($request->days == 'custom'):
            $date = explode('To', $request->filter_date);
            if(is_array($date)) {
                $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
            }
            $subDays   = $from;
            $todayDate = $to;

        else:
            $subDays                        = Carbon::parse(Carbon::today()->subDays(7)->format('Y-m-d'))->startOfDay()->toDateTimeString(); //start time today to 7 days previus date
            $todayDate                      = Carbon::parse(Carbon::today()->addDays(1)->format('Y-m-d'))->endOfDay()->toDateTimeString();// end time today date
        endif;

        $data=[];
        $data['from']                   = $subDays;
        $data['to']                     = $todayDate;

        return $data;
    }

    public function Dates($request){

        // $todayDate                      = Carbon::today()->format('Y-m-d');//today date
        // $subDays                        = Carbon::today()->subDays(7)->format('Y-m-d'); // today to 7 days previus date

        if($request->days     == 'today'):
            $startDate                      = Carbon::today()->format('Y-m-d');//today date
            $endDate                        = Carbon::today()->format('Y-m-d'); // today date
            $subDays                        = Carbon::parse(trim($startDate))->startOfDay()->toDateTimeString();
            $todayDate                      = Carbon::parse(trim($endDate))->endOfDay()->toDateTimeString();

        elseif($request->days     == 'week'):
            $todayDate                      = Carbon::today()->addDays(1)->format('Y-m-d');//today date
            $subDays                        = Carbon::today()->subDays(7)->format('Y-m-d'); // today to 7 days previus date

        elseif($request->days     == '15days'):
            $todayDate                      = Carbon::today()->addDays(1)->format('Y-m-d');//today date
            $subDays                        = Carbon::today()->subDays(15)->format('Y-m-d'); // today to 15days previus date
        elseif($request->days == 'month'):
            $todayDate                      = Carbon::today()->addDays(1)->format('Y-m-d');//today date
            $subDays                        = Carbon::today()->subDays(30)->format('Y-m-d'); // today to 30 days previus date
        elseif($request->days == 'yesterday'):
            $todayDate                      = Carbon::today()->format('Y-m-d');//yesterday date
            $subDays                        = Carbon::today()->subDays(1)->format('Y-m-d'); // yesterday
        elseif($request->days == 'custom'):
            $date = explode('To', $request->filter_date);
            if(is_array($date)) {
                $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
            }
            $subDays   = $from;
            $todayDate = $to;

        else:
            $todayDate                      = Carbon::today()->addDays(1)->format('Y-m-d');//today date
            $subDays                        = Carbon::today()->subDays(7)->format('Y-m-d'); // today to 7 days previus date
        endif;

        $totaldays                         = Carbon::parse($subDays)->diffInDays($todayDate);//today date to previus date total days

        $d=$subDays;
        $dates=[];
        for ($i=0; $i < $totaldays; $i++) {
            $dates[] = Carbon::parse($d)->addHours(24)->format('d-m-Y');
            $d       = Carbon::parse($d)->addHours(24)->format('d-m-Y');
        }


        return $dates;
    }

    public function incomeDate($request){
         //
    }
    public function expenseDate($request){
         //
    }



    public function parcelPosition($request,$status,$date){

        return Parcel::where('status',$status)->whereBetween('created_at',[$date['from'],$date['to']])->get();
    }


    public function recentAccounts($request,$date){
        return Account::where('status',Status::ACTIVE)->whereBetween('created_at',[$date['from'],$date['to']])->orderBy('id','desc')->limit(5)->get();//recent accounts
    }

    public function salaryGenerated($date){


          return SalaryGenerate::whereBetween('created_at',[$date['from'],$date['to']])->get();
    }
    public function salary($date){
        return Salary::whereBetween('created_at',[$date['from'],$date['to']])->get();
    }

    public function salaries($date){
        return Salary::whereBetween('created_at',[$date['from'],$date['to']]);
    }


    public function bankTransaction($date){
        return BankTransaction::whereBetween('created_at',[$date['from'],$date['to']])->orderByDesc('id')->limit(5)->get();
    }


    public function income($date){
        return Income::whereBetween('date',[$date['from'],$date['to']])->sum('amount');//total income
    }
    public function expense($date){
        return Expense::whereBetween('date',[$date['from'],$date['to']])->sum('amount');//total expense
    }
    public function merchantIncome($date){
        return MerchantStatement::whereBetween('date',[$date['from'],$date['to']])->where('type',AccountHeads::INCOME)->sum('amount');//merchant total income
    }
    public function merchantExpense($date){
        return  MerchantStatement::whereBetween('date',[$date['from'],$date['to']])->where('type',AccountHeads::EXPENSE)->sum('amount');//merchant total expense
    }
    public function deliverymanIncome($date){
        return DeliverymanStatement::whereBetween('date',[$date['from'],$date['to']])->where('type',AccountHeads::INCOME)->sum('amount');//Deliveryman total income
    }
    public function deliverymanExpense($date){
        return DeliverymanStatement::whereBetween('date',[$date['from'],$date['to']])->where('type',AccountHeads::EXPENSE)->sum('amount');//Deliveryman total expense
    }

    public function courierIncome($date){
        return CourierStatement::whereBetween('date',[$date['from'],$date['to']])->where('type',AccountHeads::INCOME)->sum('amount');//Courier total income
    }
    public function courierExpense($date){
        return CourierStatement::whereBetween('date',[$date['from'],$date['to']])->where('type',AccountHeads::EXPENSE)->sum('amount');//Courier total Expense
    }

}
