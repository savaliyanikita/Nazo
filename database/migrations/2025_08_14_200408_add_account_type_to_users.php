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
        Schema::table('users', function (Blueprint $t) {
            $t->enum('account_type', ['personal','business'])
              ->default('personal')->after('email');
            $t->string('company_name')->nullable()->after('account_type');
        });
    }
    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['account_type','company_name']);
        });
    }
};
