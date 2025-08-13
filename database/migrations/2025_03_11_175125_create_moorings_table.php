<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moorings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('capacity');
            $table->float('max_length');
            $table->float('max_draft');
            $table->float('max_beam');
            $table->integer('price_per_night');
            $table->timestamps();
        });
    }
};
