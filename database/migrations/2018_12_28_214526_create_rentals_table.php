<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('rental_item_id')->unsigned();
            $table->integer('rental_user')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('rental_item_id')->references('id')->on('rental_items')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('rental_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::table('rentals', function (Blueprint $table) {    
            $table->dropForeign(['client_id']);
            $table->dropForeign(['rental_item_id']);
            $table->dropForeign(['rental_user']);
        });
        Schema::dropIfExists('rentals');
    }
}
