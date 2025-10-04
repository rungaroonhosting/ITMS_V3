<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            // เช็คก่อนว่ามีคอลัมน์หรือยัง
            if (!Schema::hasColumn('departments', 'code')) {
                $table->string('code', 20)->nullable()->after('name');
            }
            
            if (!Schema::hasColumn('departments', 'express_enabled')) {
                $table->boolean('express_enabled')->default(false)->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            if (Schema::hasColumn('departments', 'code')) {
                $table->dropColumn('code');
            }
            
            if (Schema::hasColumn('departments', 'express_enabled')) {
                $table->dropColumn('express_enabled');
            }
        });
    }
};