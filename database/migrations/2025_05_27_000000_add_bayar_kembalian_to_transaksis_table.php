<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->decimal('bayar', 10, 2)->default(0)->after('total_akhir');
            $table->decimal('kembalian', 10, 2)->default(0)->after('bayar');
        });
    }
     
    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['bayar', 'kembalian']);
        });
    }
}; 