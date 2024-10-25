<?php

use App\Models\Sponsor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sponsor::class,'sponsor');
            $table->integer('kuota');
            $table->integer('sisa');
            $table->date('pengambilan');
            $table->integer('jam');
            $table->string('lokasi');
            $table->string('maps');
            $table->text('catatan')->nullable();
            $table->enum('status',["aktif","selesai"]);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
