<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('case_manager_id');
            $table->integer('attendance')->default(100);
            $table->integer('refill_deno');
            $table->integer('refill_numo');
            $table->integer('viral_load_deno');
            $table->integer('viral_load_numo');
            $table->integer('ict_deno');
            $table->integer('ict_numo');
            $table->integer('tpt_deno');
            $table->integer('tpt_numo');
            $table->string('comment')->nullable();
            $table->string('tag')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('reports');
    }
}
