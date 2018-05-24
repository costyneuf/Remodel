<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procedures', function($table) {
            $table->string('date');
            $table->string('location');
            $table->string('room');
            $table->string('case_procedure');
            $table->string('patient_class');
            $table->string('proc_start');
            $table->string('proj_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procedures', function($table) {
            $table->dropColumn('date');
            $table->dropColumn('location');
            $table->dropColumn('room');
            $table->dropColumn('case_procedure');
            $table->dropColumn('patient_class');
            $table->dropColumn('proc_start');
            $table->dropColumn('proj_end');
        });
    }
}
