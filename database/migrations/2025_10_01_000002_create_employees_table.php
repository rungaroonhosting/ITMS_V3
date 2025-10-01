<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code', 20)->unique()->comment('รหัสพนักงาน');
            $table->string('keycard_id', 50)->nullable()->unique()->comment('รหัส Keycard');
            
            $table->string('name_th', 100)->comment('ชื่อภาษาไทย');
            $table->string('surname_th', 100)->comment('นามสกุลภาษาไทย');
            $table->string('name_en', 100)->nullable()->comment('ชื่อภาษาอังกฤษ');
            $table->string('surname_en', 100)->nullable()->comment('นามสกุลภาษาอังกฤษ');
            $table->string('nickname', 50)->nullable()->comment('ชื่อเล่น');
            
            $table->string('username_computer', 50)->nullable()->unique()->comment('Username Computer');
            $table->string('password_computer', 255)->nullable()->comment('Password Computer (Encrypted)');
            $table->string('photocopy_code', 4)->nullable()->comment('รหัสถ่ายเอกสาร 4 หลัก');
            
            $table->string('email', 100)->nullable()->unique()->comment('อีเมลพนักงาน');
            $table->string('email_password', 255)->nullable()->comment('รหัสผ่านอีเมล (Encrypted)');
            
            $table->foreignId('department_id')->constrained('departments')->onDelete('restrict')->comment('แผนกที่สังกัด');
            
            $table->string('express_username', 7)->nullable()->comment('Express Username 7 ตัวอักษร');
            $table->string('express_code', 4)->nullable()->comment('Express Code 4 หลัก');
            
            $table->boolean('can_print_color')->default(false)->comment('สิทธิ์พิมพ์สี');
            $table->boolean('can_use_vpn')->default(false)->comment('สิทธิ์ใช้ VPN');
            
            $table->boolean('is_active')->default(true)->comment('สถานะการทำงาน');
            $table->date('start_date')->nullable()->comment('วันที่เริ่มงาน');
            $table->date('end_date')->nullable()->comment('วันที่ลาออก');
            
            $table->timestamps();

            $table->index('employee_code');
            $table->index('keycard_id');
            $table->index('email');
            $table->index('department_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
