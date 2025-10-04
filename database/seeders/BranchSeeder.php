<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $branches = [
            [
                'name' => 'สำนักงานใหญ่',
                'code' => 'HQ',
                'address' => '123 ถนนสุขุมวิท แขวงคลองเตย เขตคลองเตย กรุงเทพฯ 10110',
                'phone' => '02-123-4567',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'สาขาเชียงใหม่',
                'code' => 'CNX',
                'address' => '456 ถนนนิมมานเหมินท์ ตำบลสุเทพ อำเภอเมือง เชียงใหม่ 50200',
                'phone' => '053-123-456',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'สาขาภูเก็ต',
                'code' => 'PKT',
                'address' => '789 ถนนราษฎร์อุทิศ ตำบลตลาดใหญ่ อำเภอเมือง ภูเก็ต 83000',
                'phone' => '076-123-456',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'สาขาขอนแก่น',
                'code' => 'KKN',
                'address' => '321 ถนนมิตรภาพ ตำบลในเมือง อำเภอเมือง ขอนแก่น 40000',
                'phone' => '043-123-456',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'สาขาหาดใหญ่',
                'code' => 'HDY',
                'address' => '654 ถนนเพชรเกษม ตำบลหาดใหญ่ อำเภอหาดใหญ่ สงขลา 90110',
                'phone' => '074-123-456',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('branches')->insert($branches);
        
        $this->command->info('✅ Branches seeded successfully!');
    }
}