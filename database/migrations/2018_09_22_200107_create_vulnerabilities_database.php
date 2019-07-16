<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVulnerabilitiesDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vulnerabilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->integer('user_id')->comment('The author of the issue');
            $table->integer('parent_id')->default(0)->comment('This determines if this is a variant or not');
            $table->text('description');
            $table->text('body');
            $table->text('remediation');
            $table->text('references');
            $table->string('cvss_vector')->default('');
            $table->string('owasp_id');
            $table->string('nessus_id');
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
        Schema::dropIfExists('vulnerabilities');
    }
}
