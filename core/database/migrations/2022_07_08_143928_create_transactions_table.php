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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id')->constrained('plans');
            $table->foreignId('user_id')->constrained()->onUpdate('restrict')->onDelete('cascade');
            $table->float('amount', 20, 8);
            $table->float('paid_amount', 20, 8)->nullable();
            $table->string('txid')->nullable();
            $table->string('hash');
            $table->text('params')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = pending, 1 = complete, 2 = canceled');
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
        Schema::dropIfExists('transactions');
    }
};
