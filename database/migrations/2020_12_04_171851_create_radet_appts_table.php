<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadetApptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radet_appts', function (Blueprint $table) {
            $table->id();
            $table->string('appt_type');
            $table->string('client_hospital_num');
            $table->string('case_manager')->nullable();
            $table->date('last_pickup_date')->nullable();
            $table->date('last_vl_date')->nullable();
            $table->date('appt_date');
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
        Schema::dropIfExists('radet_appts');
    }
}
