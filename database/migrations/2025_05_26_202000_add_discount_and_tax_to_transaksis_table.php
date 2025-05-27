<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->decimal('diskon_persen', 5, 2)->default(0)->after('total');
            $table->decimal('diskon_nominal', 10, 2)->default(0)->after('diskon_persen');
            $table->decimal('subtotal', 10, 2)->default(0)->after('diskon_nominal');
            $table->decimal('ppn', 10, 2)->default(0)->after('subtotal');
            $table->decimal('total_akhir', 10, 2)->default(0)->after('ppn');
            $table->integer('poin_didapat')->default(0)->after('total_akhir');
            $table->integer('poin_dipakai')->default(0)->after('poin_didapat');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn([
                'diskon_persen',
                'diskon_nominal',
                'subtotal',
                'ppn',
                'total_akhir',
                'poin_didapat',
                'poin_dipakai'
            ]);
        });
    }
}; 