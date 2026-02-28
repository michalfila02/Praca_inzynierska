<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mesurments', function (Blueprint $table) {
            $table->integer('ID', true)->unique('id_pomiaru_unique');
            $table->string('Device_ID', 20);
            $table->double('Temperature');
            $table->double('Pressure');
            $table->double('Humidity');
            $table->dateTime('Date');
            $table->primary(['ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesurments');
    }
};
