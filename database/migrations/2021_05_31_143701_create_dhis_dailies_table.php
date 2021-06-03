<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDhisDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhis_dailies', function (Blueprint $table) {
            $table->id();
            $table->string('facility');
            $table->string('indicator');
            $table->string('f_m_l15');
            $table->string('f_m_g15');
            $table->string('f_f_l15');
            $table->string('f_f_g15');
            $table->string('c_m_l15');
            $table->string('c_m_g15');
            $table->string('c_f_l15');
            $table->string('c_f_g15');
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
        Schema::dropIfExists('dhis_dailies');
    }
}
