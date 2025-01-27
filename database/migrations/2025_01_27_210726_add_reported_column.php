<?php

use App\Models\Donation\Donation;
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
        Schema::table('donations', function (Blueprint $table) {
            $table->enum('reported', ['sudah'])->after('partner_id')->nullable();
        });
        // foreach (Donation::all() as $item) {
        //     $item->reported = 'sudah';
        //     $item->save();
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('reported');
        });
    }
};
