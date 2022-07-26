<?php

namespace App\Providers;

use App\Repositories\MerchantDeliveryCharge\MerchantDeliveryChargeInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Role\RoleInterface', 'App\Repositories\Role\RoleRepository');
        $this->app->bind('App\Repositories\Hub\HubInterface', 'App\Repositories\Hub\HubRepository');
        $this->app->bind('App\Repositories\User\UserInterface', 'App\Repositories\User\UserRepository');
        $this->app->bind('App\Repositories\Profile\ProfileInterface', 'App\Repositories\Profile\ProfileRepository');
        $this->app->bind('App\Repositories\Designation\DesignationInterface', 'App\Repositories\Designation\DesignationRepository');
        $this->app->bind('App\Repositories\Department\DepartmentInterface', 'App\Repositories\Department\DepartmentRepository');
        $this->app->bind('App\Repositories\Merchant\MerchantInterface', 'App\Repositories\Merchant\MerchantRepository');
        $this->app->bind('App\Repositories\Merchantshops\ShopsInterface', 'App\Repositories\Merchantshops\ShopsRepository');
        $this->app->bind('App\Repositories\MerchantDeliveryCharge\MerchantDeliveryChargeInterface', 'App\Repositories\MerchantDeliveryCharge\MerchantDeliveryChargeRepository');
        $this->app->bind('App\Repositories\DeliveryMan\DeliveryManInterface', 'App\Repositories\DeliveryMan\DeliveryManRepository');
        $this->app->bind('App\Repositories\HubInCharge\HubInChargeInterface', 'App\Repositories\HubInCharge\HubInChargeRepository');
        $this->app->bind('App\Repositories\Parcel\ParcelInterface', 'App\Repositories\Parcel\ParcelRepository');
        $this->app->bind('App\Repositories\Deliverycategory\DeliverycategoryInterface', 'App\Repositories\Deliverycategory\DeliverycategoryRepository');
        $this->app->bind('App\Repositories\DeliveryCharge\DeliveryChargeInterface', 'App\Repositories\DeliveryCharge\DeliveryChargeRepository');
        $this->app->bind('App\Repositories\Packaging\PackagingInterface', 'App\Repositories\Packaging\PackagingRepository');
        $this->app->bind('App\Repositories\MerchantPayment\PaymentInterface', 'App\Repositories\MerchantPayment\PaymentRepository');
        $this->app->bind('App\Repositories\Account\AccountInterface', 'App\Repositories\Account\AccountRepository');
        $this->app->bind('App\Repositories\Merchantmanage\Payment\PaymentInterface', 'App\Repositories\Merchantmanage\Payment\PaymentRepository');
        $this->app->bind('App\Repositories\FundTransfer\FundTransferInterface', 'App\Repositories\FundTransfer\FundTransferRepository');
        $this->app->bind('App\Repositories\MerchantProfile\MerchantProfileInterface', 'App\Repositories\MerchantProfile\MerchantProfileRepository');
        $this->app->bind('App\Repositories\DeliveryType\DeliveryTypeInterface', 'App\Repositories\DeliveryType\DeliveryTypeRepository');
        $this->app->bind('App\Repositories\Expense\ExpenseInterface', 'App\Repositories\Expense\ExpenseRepository');
        $this->app->bind('App\Repositories\Salary\SalaryInterface', 'App\Repositories\Salary\SalaryRepository');
        $this->app->bind('App\Repositories\BankTransaction\BankTransactionInterface', 'App\Repositories\BankTransaction\BankTransactionRepository');
        $this->app->bind('App\Repositories\NewsOffer\NewsOfferInterface', 'App\Repositories\NewsOffer\NewsOfferRepository');
        $this->app->bind('App\Repositories\Fraud\FraudInterface', 'App\Repositories\Fraud\FraudRepository');

        //merchant panel
        $this->app->bind('App\Repositories\MerchantPanel\PaymentAccount\PaymentAccountInterface', 'App\Repositories\MerchantPanel\PaymentAccount\PaymentAccountRepository');
        $this->app->bind('App\Repositories\MerchantPanel\Shops\ShopsInterface', 'App\Repositories\MerchantPanel\Shops\ShopsRepository');
        $this->app->bind('App\Repositories\MerchantPanel\PaymentRequest\PaymentRequestInterface', 'App\Repositories\MerchantPanel\PaymentRequest\PaymentRequestRepository');
        $this->app->bind('App\Repositories\MerchantPanel\MerchantParcel\MerchantParcelInterface', 'App\Repositories\MerchantPanel\MerchantParcel\MerchantParcelRepository');
        $this->app->bind('App\Repositories\MerchantPanel\Support\SupportInterface', 'App\Repositories\MerchantPanel\Support\SupportRepository');
        $this->app->bind('App\Repositories\MerchantPanel\Fraud\FraudInterface', 'App\Repositories\MerchantPanel\Fraud\FraudRepository');

        $this->app->bind('App\Repositories\Income\IncomeInterface', 'App\Repositories\Income\IncomeRepository');
        $this->app->bind('App\Repositories\Todo\TodoInterface', 'App\Repositories\Todo\TodoRepository');
        $this->app->bind('App\Repositories\Support\SupportInterface', 'App\Repositories\Support\SupportRepository');
        //account heads
        $this->app->bind('App\Repositories\AccountHeads\AccountHeadsInterface', 'App\Repositories\AccountHeads\AccountHeadsRepository');

        $this->app->bind('App\Repositories\SmsSetting\SmsSettingInterface', 'App\Repositories\SmsSetting\SmsSettingRepository');

        $this->app->bind('App\Repositories\SmsSendSetting\SmsSendSettingInterface', 'App\Repositories\SmsSendSetting\SmsSendSettingRepository');
        $this->app->bind('App\Repositories\GeneralSettings\GeneralSettingsInterface', 'App\Repositories\GeneralSettings\GeneralSettingsRepository');

        $this->app->bind('App\Repositories\Assetcategory\AssetcategoryInterface', 'App\Repositories\Assetcategory\AssetcategoryRepository');
        $this->app->bind('App\Repositories\Asset\AssetInterface', 'App\Repositories\Asset\AssetRepository');
        $this->app->bind('App\Repositories\CashReceivedFromDeliveryman\ReceivedInterface', 'App\Repositories\CashReceivedFromDeliveryman\ReceivedRepository');
        $this->app->bind('App\Repositories\HubPaymentRequest\HubPaymentRequestInterface', 'App\Repositories\HubPaymentRequest\HubPaymentRequestRepository');
        $this->app->bind('App\Repositories\HubManage\HubPayment\HubPaymentInterface', 'App\Repositories\HubManage\HubPayment\HubPaymentRepository');
        $this->app->bind('App\Repositories\Dashboard\DashboardInterface', 'App\Repositories\Dashboard\DashboardRepository');
        $this->app->bind('App\Repositories\Reports\ReportsInterface', 'App\Repositories\Reports\ReportsRepository');
        $this->app->bind('App\Repositories\Reports\TotalSummeryReport\TotalSummeryReportInterface', 'App\Repositories\Reports\TotalSummeryReport\TotalSummeryReportRepository');

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
