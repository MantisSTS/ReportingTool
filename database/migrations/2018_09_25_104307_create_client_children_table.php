<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_children', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->timestamps();
            $table->engine = 'InnoDB';
            // $table->foreign('parent_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('client_children', function(Blueprint $table){
        //     $table->dropForeign('client_children_client_id_foreign');
        //     $table->dropColumn('client_id');
        // });
        Schema::dropIfExists('client_children');
    }
}
