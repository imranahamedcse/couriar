<?php
namespace App\Repositories\Reports\TotalSummeryReport;

interface  TotalSummeryReportInterface{

    public function parcelTotalSummeryReports($request);
    public function commissionDeliveryman($request);
    public function cashReceivedDeliveryman($request);
    public function incomeExpense($type);
    public function accounts($request);


}
