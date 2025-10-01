<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Computer;
use App\Models\Employee;

class ComputerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ดึง Employee มาอ้างอิง
        $employees = Employee::all();
        
        $computers = [
            [
                'asset_tag' => 'PC001',
                'qr_code' => 'QR20250101001',
                'brand' => 'Dell',
                'model' => 'OptiPlex 7090',
                'serial_number' => 'DL001234567',
                'specifications' => 'Intel Core i7-11700, 16GB RAM, 512GB SSD, Windows 11 Pro',
                'purchase_date' => '2024-01-15',
                'warranty_expiry' => '2027-01-15',
                'status' => 'active',
                'assigned_to' => $employees->where('employee_code', 'IT001')->first()?->id,
                'location' => 'ห้อง IT ชั้น 3',
                'qr_printed' => true,
                'notes' => 'เครื่องผู้ดูแลระบบหลัก',
            ],
            [
                'asset_tag' => 'PC002',
                'qr_code' => 'QR20250101002',
                'brand' => 'HP',
                'model' => 'ProDesk 600 G6',
                'serial_number' => 'HP001234567',
                'specifications' => 'Intel Core i5-10500, 8GB RAM, 256GB SSD, Windows 11 Pro',
                'purchase_date' => '2024-02-01',
                'warranty_expiry' => '2027-02-01',
                'status' => 'active',
                'assigned_to' => $employees->where('employee_code', 'IT002')->first()?->id,
                'location' => 'ห้อง IT ชั้น 3',
                'qr_printed' => true,
                'notes' => 'เครื่อง IT Admin',
            ],
            [
                'asset_tag' => 'PC003',
                'qr_code' => 'QR20250101003',
                'brand' => 'Lenovo',
                'model' => 'ThinkCentre M720s',
                'serial_number' => 'LN001234567',
                'specifications' => 'Intel Core i5-9400, 8GB RAM, 256GB SSD, Windows 11 Pro',
                'purchase_date' => '2024-03-10',
                'warranty_expiry' => '2027-03-10',
                'status' => 'active',
                'assigned_to' => $employees->where('employee_code', 'HR001')->first()?->id,
                'location' => 'ฝ่าย HR ชั้น 2',
                'qr_printed' => false,
                'notes' => 'เครื่องพนักงาน HR',
            ],
            [
                'asset_tag' => 'NB001',
                'qr_code' => 'QR20250101004',
                'brand' => 'ASUS',
                'model' => 'VivoBook 15',
                'serial_number' => 'AS001234567',
                'specifications' => 'Intel Core i7-1165G7, 16GB RAM, 512GB SSD, Windows 11 Home',
                'purchase_date' => '2024-04-05',
                'warranty_expiry' => '2026-04-05',
                'status' => 'active',
                'assigned_to' => null,
                'location' => 'คลังพัสดุ ชั้น 1',
                'qr_printed' => false,
                'notes' => 'Notebook สำรอง ยังไม่มอบหมาย',
            ],
            [
                'asset_tag' => 'PC004',
                'qr_code' => 'QR20250101005',
                'brand' => 'Acer',
                'model' => 'Veriton X2665G',
                'serial_number' => 'AC001234567',
                'specifications' => 'Intel Core i3-10100, 4GB RAM, 500GB HDD, Windows 10 Pro',
                'purchase_date' => '2023-08-20',
                'warranty_expiry' => '2026-08-20',
                'status' => 'maintenance',
                'assigned_to' => null,
                'location' => 'ห้องซ่อม ชั้น 3',
                'qr_printed' => true,
                'notes' => 'กำลังซ่อมแซม - RAM เสีย',
            ],
            [
                'asset_tag' => 'PC005',
                'qr_code' => 'QR20250101006',
                'brand' => 'Dell',
                'model' => 'Inspiron 3880',
                'serial_number' => 'DL002345678',
                'specifications' => 'Intel Core i5-10400, 8GB RAM, 1TB HDD, Windows 11 Home',
                'purchase_date' => '2023-12-10',
                'warranty_expiry' => '2026-12-10',
                'status' => 'inactive',
                'assigned_to' => null,
                'location' => 'คลังพัสดุ ชั้น 1',
                'qr_printed' => false,
                'notes' => 'เก่า ไม่ใช้งาน รอการตัดสินใจ',
            ],
            [
                'asset_tag' => 'SRV001',
                'qr_code' => 'QR20250101007',
                'brand' => 'Dell',
                'model' => 'PowerEdge T340',
                'serial_number' => 'DL003456789',
                'specifications' => 'Intel Xeon E-2224, 32GB RAM, 2TB HDD RAID1, Windows Server 2022',
                'purchase_date' => '2024-01-01',
                'warranty_expiry' => '2029-01-01',
                'status' => 'active',
                'assigned_to' => $employees->where('employee_code', 'IT001')->first()?->id,
                'location' => 'Server Room ชั้น 3',
                'qr_printed' => true,
                'notes' => 'File Server หลักของบริษัท',
            ],
            [
                'asset_tag' => 'NB002',
                'qr_code' => 'QR20250101008',
                'brand' => 'MacBook',
                'model' => 'MacBook Air M2',
                'serial_number' => 'MB001234567',
                'specifications' => 'Apple M2, 16GB RAM, 512GB SSD, macOS Ventura',
                'purchase_date' => '2024-05-15',
                'warranty_expiry' => '2025-05-15',
                'status' => 'active',
                'assigned_to' => null,
                'location' => 'ฝ่ายขาย ชั้น 2',
                'qr_printed' => false,
                'notes' => 'สำหรับงาน Creative และ Presentation',
            ],
        ];

        foreach ($computers as $computer) {
            Computer::firstOrCreate(
                ['asset_tag' => $computer['asset_tag']],
                $computer
            );
        }

        $this->command->info('Computer seeder completed successfully!');
        $this->command->info('Total computers: ' . Computer::count());
    }
}