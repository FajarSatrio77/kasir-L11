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
        Schema::table('produks', function (Blueprint $table) {
            if (!Schema::hasColumn('produks', 'name')) {
                $table->string('name');
            }
            if (!Schema::hasColumn('produks', 'kode')) {
                $table->string('kode')->unique();
            }
            if (!Schema::hasColumn('produks', 'harga')) {
                $table->decimal('harga', 10, 2);
            }
            if (!Schema::hasColumn('produks', 'stok')) {
                $table->integer('stok');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['name', 'kode', 'harga', 'stok']);
        });
    }
};
