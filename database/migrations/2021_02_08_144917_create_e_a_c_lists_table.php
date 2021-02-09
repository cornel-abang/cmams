<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEACListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_a_c_lists', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->integer('current_viral_load')->nullable();
            $table->string('case_manager')->nullable();
            $table->date('art_start_date');
            $table->date('last_vl_result');
            $table->string('facility')->nullable();
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
        Schema::dropIfExists('e_a_c_lists');
    }
}
