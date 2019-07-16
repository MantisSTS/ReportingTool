<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment('The name of the phase');
            $table->integer('report_id')->unsigned()->comment('The report that the phase relates to');
            $table->integer('author_id')->unsigned()->comment('The author of the phase');
            $table->string('prefix', 3)->comment('The issue prefix such as WEB, INT, MOB, etc');
            $table->text('comments')->nullable()->comment('Any comments regarding the phase');
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
        Schema::dropIfExists('phases');
    }
}
