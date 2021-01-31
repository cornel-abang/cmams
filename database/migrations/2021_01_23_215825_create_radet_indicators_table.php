<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadetIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radet_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('refill')->nullable();
            $table->integer('refill_exp')->nullable();
            $table->integer('refill_met')->nullable();
            $table->integer('refill_pc')->nullable();
            $table->string('vlc')->nullable();
            $table->integer('vlc_exp')->nullable();
            $table->integer('vlc_met')->nullable();
            $table->integer('vlc_pc')->nullable();
            $table->integer('tpt_exp')->nullable();
            $table->integer('tpt_met')->nullable();
            $table->integer('tpt_pc')->nullable();
            $table->string('attendance')->nullable();
            $table->string('case_manager')->nullable();
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
        Schema::dropIfExists('radet_indicators');
    }
}
