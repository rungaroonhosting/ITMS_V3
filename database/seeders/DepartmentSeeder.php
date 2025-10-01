<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'ฝ่ายเทคโนโลยีสารสนเทศ (IT)',
                'description' => 'รับผิดชอบด้านเทคโนโลยีสารสนเทศ ระบบคอมพิวเตอร์ และเครือข่าย',
                'is_active' => true,
            ],
            [
                'name' => 'ฝ่ายบุคคล (HR)',
                'description' => 'รับผิดชอบด้านทรัพยากรบุคคล การสรรหา และการพัฒนาบุคลากร',
                'is_active' => true,
            ],
            [
                'name' => 'ฝ่ายบัญชีและการเงิน',
                'description' => 'รับผิดชอบด้านบัญชี การเงิน และการควบคุมงบประมาณ',
                'is_active' => true,
            ],
            [
                'name' => 'ฝ่ายขายและการตลาด',
                'description' => 'รับผิดชอบด้านการขาย การตลาด และการประชาสัมพันธ์',
                'is_active' => true,
            ],
            [
                'name' => 'ฝ่ายปฏิบัติการ',
                'description' => 'รับผิดชอบด้านการปฏิบัติงาน การผลิต และการควบคุมคุณภาพ',
                'is_active' => true,
            ],
            [
                'name' => 'ฝ่ายจัดซื้อจัดจ้าง',
                'description' => 'รับผิดชอบด้านการจัดซื้อจัดจ้าง การเก็บรักษาพัสดุ และการควบคุมคลังสินค้า',
                'is_active' => true,
            ],
            [
                'name' => 'ฝ่ายกฎหมายและงานทั่วไป',
                'description' => 'รับผิดชอบด้านกฎหมาย การประสานงาน และงานสนับสนุนทั่วไป',
                'is_active' => true,
            ],
            [
                'name' => 'ฝ่ายวิจัยและพัฒนา (R&D)',
                'description' => 'รับผิดชอบด้านการวิจัย การพัฒนาผลิตภัณฑ์ และนวัตกรรม',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['name' => $department['name']],
                $department
            );
        }

        $this->command->info('Department seeder completed successfully!');
    }
}