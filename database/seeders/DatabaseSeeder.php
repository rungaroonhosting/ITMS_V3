<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting ITMS Database Seeding...');
        
        // เรียงลำดับการ Seed ตาม Dependencies
        $this->call([
            DepartmentSeeder::class,
            //UserSeeder::class,  // จะสร้าง Employees ด้วย
            ComputerSeeder::class,
        ]);
        
        $this->command->info('✅ ITMS Database Seeding completed successfully!');
        $this->command->info('');
        $this->command->info('🔐 Default Login Credentials:');
        $this->command->info('-----------------------------------');
        $this->command->info('Super Admin:');
        $this->command->info('Email: wittaya.j@better-groups.com');
        $this->command->info('Password: Admin@123');
        $this->command->info('');
        $this->command->info('IT Admin:');
        $this->command->info('Email: itadmin@company.com');
        $this->command->info('Password: ITAdmin@123');
        $this->command->info('');
        $this->command->info('Employee Demo:');
        $this->command->info('Email: somchai@company.com');
        $this->command->info('Password: User@123');
        $this->command->info('-----------------------------------');
    }
}