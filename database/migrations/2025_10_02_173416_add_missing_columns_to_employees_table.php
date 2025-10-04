<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Names
            if (!Schema::hasColumn('employees', 'first_name_th')) {
                $table->string('first_name_th', 100)->after('employee_code');
            }
            if (!Schema::hasColumn('employees', 'last_name_th')) {
                $table->string('last_name_th', 100)->after('first_name_th');
            }
            if (!Schema::hasColumn('employees', 'first_name_en')) {
                $table->string('first_name_en', 100)->nullable()->after('last_name_th');
            }
            if (!Schema::hasColumn('employees', 'last_name_en')) {
                $table->string('last_name_en', 100)->nullable()->after('first_name_en');
            }
            if (!Schema::hasColumn('employees', 'nickname')) {
                $table->string('nickname', 50)->nullable()->after('last_name_en');
            }
            
            // Passwords
            if (!Schema::hasColumn('employees', 'computer_password')) {
                $table->string('computer_password')->nullable();
            }
            if (!Schema::hasColumn('employees', 'email_password')) {
                $table->string('email_password')->nullable();
            }
            
            // Permissions
            if (!Schema::hasColumn('employees', 'vpn_access')) {
                $table->boolean('vpn_access')->default(false);
            }
            if (!Schema::hasColumn('employees', 'color_printing')) {
                $table->boolean('color_printing')->default(false);
            }
            if (!Schema::hasColumn('employees', 'remote_work')) {
                $table->boolean('remote_work')->default(false);
            }
            if (!Schema::hasColumn('employees', 'admin_access')) {
                $table->boolean('admin_access')->default(false);
            }
            
            // Login email
            if (!Schema::hasColumn('employees', 'login_email')) {
                $table->string('login_email')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'first_name_th', 'last_name_th', 'first_name_en', 'last_name_en', 'nickname',
                'computer_password', 'email_password',
                'vpn_access', 'color_printing', 'remote_work', 'admin_access',
                'login_email'
            ]);
        });
    }
};