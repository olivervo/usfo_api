<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('insass_year')->nullable();
            $table->string('DOB')->nullable();
            $table->string('bank')->nullable();
            $table->string('clearing_number')->nullable();
            $table->string('account_number')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();
            $table->string('allergies')->nullable();
            $table->date('registry_checked_at')->nullable();
            $table->foreignId('user_id')->unique()->constrained();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
};
