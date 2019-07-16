<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportVulnerabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_vulnerabilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id');
            $table->integer('user_id');
            $table->integer('client_id');
            $table->integer('vuln_id');
            $table->text('vuln_changes')->nullable()->comment('This can be used to change the default vulnerabilities within each report');
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
        Schema::dropIfExists('report_vulnerabilities');
    }
}
