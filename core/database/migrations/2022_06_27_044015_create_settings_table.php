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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('sitename');
            $table->string('logo');
            $table->string('favicon');
            $table->string('keywords');
            $table->string('description');
            $table->string('telegram')->nullable();
            $table->string('currency');
            $table->string('cur_sym');
            $table->integer('wallet_min');
            $table->integer('wallet_max');
            $table->integer('charge');
            $table->decimal('min_withdraw', 18, 8);
            $table->decimal('max_withdraw', 18, 8);
            $table->integer('ref_commission')->comment('Referral commission in %');
            $table->string('pub_key')->nullable();
            $table->string('pri_key')->nullable();
            $table->string('trongrid_api')->nullable();
            $table->string('cp_pub_key')->nullable();
            $table->string('cp_pri_key')->nullable();
            $table->string('cp_merchant')->nullable();
            $table->string('coin_hash')->nullable();
            $table->integer('gateway_charge')->default(0);
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
        Schema::dropIfExists('settings');
    }
};
