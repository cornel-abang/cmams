<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soft_results', function (Blueprint $table) {
            $table->id();
            $table->string('facility');
            $table->string('pepfar_id')->nullable();
            $table->string('hospital_num')->nullable();
            $table->string('result')->nullable();
            $table->string('fac_hosp_id')->nullable();
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
        Schema::dropIfExists('soft_results');
    }
}
