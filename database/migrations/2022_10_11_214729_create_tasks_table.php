<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('string');
            $table->integer('frequency');
            $table->integer('number_of_repetitions');
            $table->string('algorithm_name');
            $table->string('salt');
            $table->string('status_complete')->default('Not completed');
            $table->string('hash_string')->nullable()->default('Hash not ready');
            $table->integer('group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
