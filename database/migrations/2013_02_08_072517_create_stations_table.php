<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('COMPANY_MAKE');
            $table->string('FULLNAME');
            $table->string('voltage_level');
            $table->string('Contract_No');
            $table->string('COMMISINNG_DATE');
            $table->string('control');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stations');
    }
}
