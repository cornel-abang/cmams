<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('clientID');
            $table->string('type');
            $table->date('appt_date');
            $table->timestamps();
            $table->foreign('clientID')->references('clientID')->on('clients')->onDelete('no action')->onUpdate('no action');
            $table->foreign('email')->references('email')->on('case_managers')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
