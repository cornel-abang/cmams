<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDhisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhis', function (Blueprint $table) {
            $table->id();
            $table->string('sn')->nullable();
            $table->string('indicator')->nullable();
            $table->string('special')->nullable();
            $table->string('not_greater_than')->nullable();
            $table->string('tag')->nullable();
            $table->text('validation_text')->nullable();
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
        Schema::dropIfExists('dhis');
    }
}
