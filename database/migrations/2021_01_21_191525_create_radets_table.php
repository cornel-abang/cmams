<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radets', function (Blueprint $table) {
            $table->id();
            $table->string('client_hospital_num')->nullable();
            $table->date('last_pickup_date')->nullable();
            $table->integer('months_of_refil')->nullable();
            $table->string('facility')->nullable();
            $table->date('date_of_viral_load')->nullable();
            $table->string('tpt_in_the_last_2_years')->nullable();
            $table->date('if_yes_to_tpt_date_of_tpt_start_yyyy_mm_dd')->nullable();
            $table->date('tpt_completion_date_yyyy_mm_dd')->nullable();
            $table->date('art_start_date')->nullable();
            $table->string('art_status')->nullable();
            $table->date('date_of_current_viral_load')->nullable();
            $table->string('current_viral_load')->nullable();
            $table->date('last_vl_result')->nullable();
            $table->string('current_regimen')->nullable();
            $table->string('regimen_at_art_start')->nullable();
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
        Schema::dropIfExists('radets');
    }
}
