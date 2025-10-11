<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->integer('stock')->default(0)->after('price');
            $table->string('sku')->nullable()->after('name');

        });
    }

    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->dropColumn('stock');
        });
    }
};
