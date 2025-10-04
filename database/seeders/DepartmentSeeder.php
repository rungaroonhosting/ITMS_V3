<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $departments = [
            [
                'name' => 'IT',
                'code' => 'IT',
                'description' => 'แผนกเทคโนโลยีสารสนเทศ',
                'express_enabled' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'HR',
                'code' => 'HR',
                'description' => 'แผนกทรัพยากรบุคคล',
                'express_enabled' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Accounting',
                'code' => 'ACC',
                'description' => 'แผนกบัญชี',
                'express_enabled' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sales',
                'code' => 'SALES',
                'description' => 'แผนกขาย',
                'express_enabled' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'แผนกการตลาด',
                'express_enabled' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'แผนกการเงิน',
                'express_enabled' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Operations',
                'code' => 'OPS',
                'description' => 'แผนกปฏิบัติการ',
                'express_enabled' => false,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Purchasing',
                'code' => 'PUR',
                'description' => 'แผนกจัดซื้อ',
                'express_enabled' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('departments')->insert($departments);
        
        $this->command->info('✅ Departments seeded successfully!');
    }
}