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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_default')->default(0)->nullable();
            $table->decimal('point_per_day', 20, 8)->nullable();
            $table->string('version')->nullable();
            $table->decimal('earning_rate', 20, 8)->nullable();
            $table->string('image')->default('plan1.png')->nullable();
            $table->float('price', 20, 8);
            $table->integer('period');
            $table->string('profit')->nullable();
            $table->string('speed')->default(1);
            $table->boolean('status')->comment('0 = inactive, 1 = active');
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
        Schema::dropIfExists('plans');
    }
};
