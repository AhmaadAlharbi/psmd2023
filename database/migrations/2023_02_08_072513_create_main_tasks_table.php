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
            $table->string('refNum')->nullable();
            $table->unsignedBigInteger('station_id')->nullable();
            $table->String('voltage_level')->nullable();
            $table->String('equip_number')->nullable();
            $table->unsignedBigInteger('eng_id')->nullable();
            $table->date('date')->nullable();
            $table->text('problem')->nullable();
            $table->String('work_type')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('main_alarm_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('station_id')
                ->references('id')
                ->on('stations');
            $table->foreign('eng_id')
                ->references('id')
                ->on('users');
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
