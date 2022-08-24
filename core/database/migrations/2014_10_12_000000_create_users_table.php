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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('uid')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('ref_id')->nullable();
            $table->decimal('balance', 30, 8)->default(0.00000000);
            $table->decimal('ref_earn', 30, 8)->default(0.00000000);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->boolean('status')->default(1)->comment('0 = inactive, 1 = active');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
