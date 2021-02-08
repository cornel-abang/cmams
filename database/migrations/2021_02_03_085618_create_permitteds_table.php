<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermittedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permitteds', function (Blueprint $table) {
            $table->id();
            $table->string('case_manager');
            $table->string('facility')->nullable();
            $table->string('reason');
            $table->string('approved_by');
            $table->date('permit_date');
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
        Schema::dropIfExists('permitteds');
    }
}
