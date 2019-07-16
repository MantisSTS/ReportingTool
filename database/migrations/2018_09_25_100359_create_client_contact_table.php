<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->unique();
            $table->string('primary_email', 255);
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('phone_number',20);
            $table->string('fax');
            $table->timestamps();
            $table->engine = 'InnoDB';
            // $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('client_contacts', function(Blueprint $table){
        //     $table->dropForeign('client_contacts_client_id_foreign');
        //     $table->dropColumn('client_id');
        // });
        Schema::dropIfExists('client_contacts');
    }
}
