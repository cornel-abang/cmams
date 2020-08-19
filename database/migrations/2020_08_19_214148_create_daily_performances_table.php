<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_performances', function (Blueprint $table) {
            $table->id();
            $table->integer('refill_performance');
            $table->integer('attendance_performance');
            $table->integer('viral_load_performance');
            $table->integer('ict_performance');
            $table->integer('tpt_performance');
            $table->integer('tracking_performance');
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
        Schema::dropIfExists('daily_performances');
    }
}
