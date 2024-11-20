<?php

use App\Models\Donation;
use App\Models\Faculty;
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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon')->nullable();
            $table->foreignIdFor(Faculty::class,'fakultas');
            $table->enum('status',['sudah','belum']);
            $table->foreignIdFor(Donation::class,'donation');
            $table->char('kode',6)->nullable();
            $table->integer('jumlah')->default(1);
            $table->timestamps();
        });
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon')->nullable();
            $table->foreignIdFor(Faculty::class,'fakultas');
            $table->foreignIdFor(Donation::class,'donation');
            $table->char('kode',6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
