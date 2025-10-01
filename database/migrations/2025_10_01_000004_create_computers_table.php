<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag', 50)->unique()->comment('รหัสทรัพย์สิน');
            $table->string('qr_code', 100)->unique()->comment('QR Code ที่ไม่ซ้ำ');
            
            $table->string('brand', 100)->comment('ยี่ห้อ');
            $table->string('model', 100)->comment('รุ่น');
            $table->string('serial_number', 100)->nullable()->unique()->comment('Serial Number');
            $table->text('specifications')->nullable()->comment('คุณลักษณะ/สเปค');
            
            $table->date('purchase_date')->nullable()->comment('วันที่ซื้อ');
            $table->date('warranty_expiry')->nullable()->comment('วันหมดประกัน');
            $table->date('last_maintenance')->nullable()->comment('วันที่บำรุงรักษาล่าสุด');
            
            $table->enum('status', ['active', 'inactive', 'maintenance', 'disposed'])->default('active')->comment('สถานะอุปกรณ์');
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->onDelete('set null')->comment('มอบหมายให้พนักงาน');
            $table->string('location', 200)->nullable()->comment('สถานที่');
            
            $table->boolean('qr_printed')->default(false)->comment('พิมพ์ QR Code แล้วหรือยัง');
            $table->text('notes')->nullable()->comment('หมายเหตุเพิ่มเติม');
            
            $table->timestamps();

            $table->index('asset_tag');
            $table->index('qr_code');
            $table->index('serial_number');
            $table->index('status');
            $table->index('assigned_to');
            $table->index('warranty_expiry');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computers');
    }
};
