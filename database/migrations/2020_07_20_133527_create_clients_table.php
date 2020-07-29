<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facility_id');
            $table->unsignedBigInteger('case_manager_id');
            $table->string('name');
            $table->string('clientID');
            $table->string('phone');
            $table->string('opc_phone')->nullable();
            $table->string('address');
            $table->string('status');
            $table->timestamps();
            $table->foreign('facility_id')->references('id')->on('facilities');
            $table->foreign('case_manager_id')->references('id')->on('case_managers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
