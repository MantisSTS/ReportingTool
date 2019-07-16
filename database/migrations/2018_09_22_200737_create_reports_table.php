<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('client_id')->comment('The client which the test relatest to');
            $table->integer('assessment_id')->comment('The assessment which the test relatest to');
            $table->string('title', 1000)->comment('The title of the overall test');
            $table->integer('author_id')->comment('The author of the test');
            $table->text('summary')->comment('The executive summary of the overall test');
            $table->text('conclusion')->comment('Any final words to be given for the overall test');
            $table->integer('status_id')->default(0)->comment('The Status ID of the report - 0: NOT READY; 1: IN PROGRESS; ... 5: READY FOR DELIVERY');
            $table->json('contributors');
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
        Schema::dropIfExists('reports');
    }
}
