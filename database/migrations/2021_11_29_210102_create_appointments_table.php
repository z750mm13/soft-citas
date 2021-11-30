<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('description');
            $table->dateTime('datetime');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('patient_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('appointments');
    }
}
