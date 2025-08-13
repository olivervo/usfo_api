<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->integer('membership_year');
            $table->unsignedBigInteger('memberable_id');
            $table->string('memberable_type');
            $table->integer('membership_fee');
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->foreignId('payment_id')->nullable()->constrained();
            $table->enum('status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->timestamps();

            $table->unique(['membership_year', 'memberable_id', 'memberable_type', 'status'], 'unique_membership');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
