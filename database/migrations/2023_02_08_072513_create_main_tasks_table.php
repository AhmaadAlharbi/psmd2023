<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('main_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('refNum');
            $table->unsignedBigInteger('station_id');
            $table->date('date');
            $table->string('problem');
            $table->string('notes');
            $table->string('status');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('main_alarm_id');
            $table->timestamps();
            $table->foreign('station_id')
                ->references('id')
                ->on('stations');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('department_id')
                ->references('id')
                ->on('departments');
            $table->foreign('main_alarm_id')
                ->references('id')
                ->on('main_alarm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_tasks');
    }
}
