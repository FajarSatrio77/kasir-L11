<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->date('expired_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->integer('hpp')->nullable();
            $table->integer('harga_jual1')->nullable();
            $table->integer('harga_jual2')->nullable();
            $table->integer('harga_jual3')->nullable();
            $table->integer('minimal_stok')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['expired_date', 'purchase_date', 'hpp', 'harga_jual1', 'harga_jual2', 'harga_jual3', 'minimal_stok']);
        });
    }
}; 