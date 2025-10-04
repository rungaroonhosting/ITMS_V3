<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop foreign keys ที่อ้างอิงถึง employees
        Schema::table('computers', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
        });
        
        // 2. Drop employees table
        Schema::dropIfExists('employees');
        
        // 3. สร้าง employees ใหม่
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code', 20)->unique();
            $table->string('first_name_th', 100);
            $table->string('last_name_th', 100);
            $table->string('first_name_en', 100)->nullable();
            $table->string('last_name_en', 100)->nullable();
            $table->string('nickname', 50)->nullable();
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('login_email')->nullable();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('position', 100)->nullable();
            $table->string('role', 50)->default('employee');
            $table->string('status', 20)->default('active');
            $table->string('password');
            $table->string('computer_password')->nullable();
            $table->string('email_password')->nullable();
            $table->string('express_username', 7)->nullable()->unique();
            $table->string('express_password', 4)->nullable();
            $table->boolean('vpn_access')->default(false);
            $table->boolean('color_printing')->default(false);
            $table->boolean('remote_work')->default(false);
            $table->boolean('admin_access')->default(false);
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        // 4. สร้าง foreign key ใหม่ใน computers
        Schema::table('computers', function (Blueprint $table) {
            $table->foreign('assigned_to')->references('id')->on('employees')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};