<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMedicinesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('details')->default('Cambie la descripcion del detalle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn('details');
        });
    }
}
