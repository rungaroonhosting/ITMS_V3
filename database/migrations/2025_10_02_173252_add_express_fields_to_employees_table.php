<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'express_username')) {
                $table->string('express_username', 7)->nullable()->unique();
            }
            if (!Schema::hasColumn('employees', 'express_password')) {
                $table->string('express_password', 4)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['express_username', 'express_password']);
        });
    }
};