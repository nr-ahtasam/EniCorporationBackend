<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Keep the newest row for each phone and remove older duplicates.
        DB::statement('DELETE n1 FROM navbars n1 INNER JOIN navbars n2 ON n1.phone = n2.phone AND n1.id < n2.id');

        Schema::table('navbars', function (Blueprint $table): void {
            $table->unique('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('navbars', function (Blueprint $table): void {
            $table->dropUnique('navbars_phone_unique');
        });
    }
};
