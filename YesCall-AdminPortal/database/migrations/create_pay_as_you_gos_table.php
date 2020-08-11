<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayAsYouGosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_as_you_gos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package_type');
            $table->double('sms_amount', 15,8);
            $table->double('calling_amount', 15, 8);
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
        Schema::drop('pay_as_you_gos');
    }
}
