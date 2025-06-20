<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('niveaux', function (Blueprint $table) {
            $table->id();                    // id (bigIncrements)
            $table->string('name');         // A1, A2, B1, ...
            $table->integer('order');       // progression order
            $table->timestamps();           // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveaux');
    }
};
