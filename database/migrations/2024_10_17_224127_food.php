<?php

use App\Models\Donation;
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
        Schema::create('foods', function(Blueprint $table){
            $table->id();
            $table->foreignIdFor(Donation::class,'donation');
            $table->string('nama');
            $table->integer('jumlah');
            $table->integer('berat');
            $table->enum('satuan',["gr","ltr"]);
            $table->string('keterangan')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
