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
            $table->unsignedBigInteger('main_tasks_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('eng_id');
            $table->string('action_take');
            $table->string('status');
            $table->string('engineer-notes');
            $table->unsignedBigInteger('user_id');

            $table->foreign('main_tasks_id')
                ->references('id')
                ->on('main_tasks');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments');
            $table->foreign('eng_id')
                ->references('id')
                ->on('engineers');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
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
