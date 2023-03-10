<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('section_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_tasks_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('eng_id')->nullable();
            $table->date('date')->nullable();
            $table->string('action_take')->nullable();
            $table->string('status')->nullable();
            $table->string('engineer-notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('previous_department_id')->nullable();
            $table->date('transfer_date_time')->nullable();
            $table->timestamps();
            $table->foreign('main_tasks_id')
                ->references('id')
                ->on('main_tasks')
                ->onDelete('cascade');
            $table->foreign('department_id')
                ->references('id')
                ->on('departments');
            $table->foreign('eng_id')
                ->references('id')
                ->on('engineers');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('previous_department_id')
                ->references('id')
                ->on('departments');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_tasks');
    }
}
