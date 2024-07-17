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
        Schema::create('consommateurs', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Fonction');
            $table->enum('Shift', ['a', 'b', 'c', 'd']); // a, b, c, d pour morning, evening, night, off
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consommateurs');
    }
};
