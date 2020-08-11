<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('iso2');
            $table->integer('dial_code');
            $table->double('cost_per_sms');
            $table->double('cost_per_minute');
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
        Schema::drop('country_packages');
    }
}
