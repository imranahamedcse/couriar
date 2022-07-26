<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SebastianBergmann\CodeUnit\CodeUnit;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UploadSeeder::class);
        $this->call(HubSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DeliveryManSeeder::class);
        $this->call(HubInChargeSeeder::class);
        $this->call(DeliverycategorySeeder::class);
        $this->call(DeliveryChargeSeeder::class);
        $this->call(MerchantSeeder::class);
        $this->call(MerchantshopsSeeder::class);
        $this->call(MerchantPaymentSeeder::class);
        $this->call(AccountSeeder::class);
        // $this->call(MerchantManagePaymentSeeder::class);
        // $this->call(FundTransferSeeder::class);
        // $this->call(PaymentAccountSeeder::class);
        $this->call(ConfigSeeder::class);
        $this->call(PackagingSeeder::class);
        // $this->call(ParcelSeeder::class);
        $this->call(AccountHeadSeeder::class);
        // $this->call(ExpenseSeeder::class);

        $this->call(PermissionSeeder::class);
        // $this->call(IncomeSeeder::class);
        $this->call(SmsSettingsSeeder::class);
        $this->call(SmsSendSettingsSeeder::class);
        $this->call(GeneralSettingsSeeder::class);
        $this->call(SalaryGenerateSeeder::class);


    }
}
