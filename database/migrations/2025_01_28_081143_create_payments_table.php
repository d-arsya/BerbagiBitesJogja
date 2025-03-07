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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->integer('amount');
            $table->string('snap_token')->nullable();
            $table->enum('variant', ['company', 'individual']);
            $table->enum('status', ['waiting', 'cancel', 'done'])->default("waiting");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
