<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTATRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_a_t_records', function (Blueprint $table) {
            $table->id();
            $table->string('facility')->nullable();
            $table->string('patient_name')->nullable();
            $table->integer('lab_no')->nullable();
            $table->string('hospital_no')->nullable();
            $table->string('sex')->nullable();
            $table->string('age')->nullable();
            $table->string('test_type')->nullable();
            $table->string('eid_res')->nullable();
            $table->string('vl_res')->nullable();
            $table->string('gene_xpert_res')->nullable();
            $table->string('cd_4_res')->nullable();
            $table->date('date_test_requested');
            $table->integer('tat_1')->nullable();
            $table->date('date_sample_collected')->nullable();
            $table->string('time_sample_collected')->nullable();
            $table->integer('tat_2')->nullable();
            $table->date('sample_pickup_date')->nullable();
            $table->string('sample_trans_pick_by')->nullable();
            $table->date('date_sample_rec_at_lab')->nullable();
            $table->integer('tat_3')->nullable();
            $table->string('name_of_rec_testing_lab')->nullable();
            $table->date('date_samples_tested_assay_test')->nullable();
            $table->integer('tat_4')->nullable();
            $table->date('date_res_released_to_facility')->nullable();
            $table->integer('tat_5')->nullable();
            $table->date('date_res_reci_at_clinic')->nullable();
            $table->integer('tat_6')->nullable();
            $table->date('date_res_entered_into_med_record')->nullable();
            $table->integer('tat_7')->nullable();
            $table->date('date_patient_notified_res_ready')->nullable();
            $table->integer('tat_8')->nullable();
            $table->date('date_res_given_to_patient')->nullable();
            $table->integer('overall_tat')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('t_a_t_records');
    }
}
