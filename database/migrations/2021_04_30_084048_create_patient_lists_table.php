<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_lists', function (Blueprint $table) {
            $table->id();
            $table->string('hospital_num')->nullable();
            $table->string('status')->nullable();
            $table->string('case_manager')->nullable();
            $table->string('facility')->nullable();
            $table->string('name')->nullable();
            $table->string('facility_hospital_number')->nullable();
            $table->string('sex')->nullable();
            $table->date('date_of_birth')->nullable();
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
        Schema::dropIfExists('patient_lists');
    }
}
