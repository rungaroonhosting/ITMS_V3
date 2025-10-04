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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('รหัสสาขา');
            $table->string('name', 100)->comment('ชื่อสาขา');
            $table->text('address')->nullable()->comment('ที่อยู่');
            $table->string('phone', 20)->nullable()->comment('เบอร์โทร');
            $table->string('email', 100)->nullable()->comment('อีเมล');
            $table->foreignId('manager_id')->nullable()->comment('ผู้จัดการสาขา');
            $table->boolean('is_active')->default(true)->comment('สถานะใช้งาน');
            $table->timestamps();
            
            // Indexes
            $table->index('code');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};