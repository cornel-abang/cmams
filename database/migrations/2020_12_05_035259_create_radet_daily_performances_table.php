<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadetDailyPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radet_daily_performances', function (Blueprint $table) {
            $table->id();
            $table->integer('refill_performance');
            $table->integer('viral_load_performance');
            $table->integer('tpt_performance');
            $table->integer('attendance_performance')->default(0);
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
        Schema::dropIfExists('radet_daily_performances');
    }
}
