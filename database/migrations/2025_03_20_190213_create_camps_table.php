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
        Schema::create('camps', function (Blueprint $table) {
            $table->id();
            $table->string('camp_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('age_group')->nullable();
            $table->string('camp_category')->nullable();
            $table->integer('camp_fee');
            $table->integer('number_males');
            $table->integer('number_females');
            $table->year('year');
            $table->string('registration_code')->nullable();
            $table->dateTime('publish_at')->nullable();
            $table->decimal('weeks');
            $table->timestamps();
        });
    }
};
