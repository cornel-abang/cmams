<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVLCLookupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v_l_c_lookups', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->date('art_start_date');
            $table->date('last_sample_collection')->nullable();
            $table->date('date_of_current_vl')->nullable();
            $table->string('current_vl')->nullable();
            $table->date('last_vl_result')->nullable();
            $table->string('current_system_status');
            $table->string('regimen_at_start')->nullable();
            $table->string('current_regimen_type')->nullable();
            $table->date('last_vlc_date')->nullable();
            $table->string('result_status')->nullable();
            $table->string('case_manager')->nullable();
            $table->string('facility');
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
        Schema::dropIfExists('v_l_c_lookups');
    }
}
