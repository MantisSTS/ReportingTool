<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_status', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('report_id');
            $table->string('status', 255)->unique()->default('')->comment('The status text, eg: STARTED, IN_PROGRESS, etc');
            $table->timestamps();
            $table->engine = 'InnoDB';
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_status');
    }
}
