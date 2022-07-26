<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('business_name');
            $table->string('merchant_unique_id')->nullable();
            $table->decimal('current_balance',16,2)->default(0);
            $table->decimal('opening_balance',16,2)->default(0);
            $table->decimal('vat',16,2)->default(0);
            $table->longText('cod_charges')->nullable();
            $table->foreignId('nid_id')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->foreignId('trade_license')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->unsignedTinyInteger('status')->default(\App\Enums\Status::ACTIVE)->comment(\App\Enums\Status::ACTIVE.'='.trans('status.'.\App\Enums\Status::ACTIVE).', ' .\App\Enums\Status::INACTIVE.'='.trans('status.'.\App\Enums\Status::INACTIVE));
            $table->longText('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
};
