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
        $tables = ['products', 'product_images', 'product_sizes', 'categories', 'users'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->change();
                $table->timestamp('updated_at')->nullable()->default(null)->change();
            });
        }
    }
    
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();
        });
        Schema::table('product_images', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();
        });
        Schema::table('product_sizes', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();
        });
    }
};
