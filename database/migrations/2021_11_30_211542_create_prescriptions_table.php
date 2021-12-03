<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('dose')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('consultation_id')->unsigned();
            $table->bigInteger('medicine_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('prescriptions');
    }
}
