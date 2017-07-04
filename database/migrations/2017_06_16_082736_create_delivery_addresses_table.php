<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('uid')->unsigned();
            //$table->foreign('uid')->references('uid')->on('discuz_common_member');
            $table->string('area', 60);
            $table->string('name', 60);
            $table->string('detail', 60);
            $table->string('mobile', 60);
            $table->string('telephone', 60);
            $table->string('email', 100);
            $table->string('alias', 60);
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
        Schema::dropIfExists('delivery_addresses');
    }
}
