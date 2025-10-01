<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // สร้าง IT Department (ถ้ายังไม่มี)
        $itDepartment = Department::firstOrCreate([
            'name' => 'ฝ่ายเทคโนโลยีสารสนเทศ (IT)'
        ]);

        // สร้าง Super Admin Employee
        $superAdminEmployee = Employee::firstOrCreate([
            'employee_code' => 'IT001'
        ], [
            'employee_code' => 'IT001',
            'keycard_id' => 'ADMIN001',
            'name_th' => 'ผู้ดูแลระบบ',
            'surname_th' => 'หลัก',
            'name_en' => 'System',
            'surname_en' => 'Administrator',
            'nickname' => 'Admin',
            'username_computer' => 'administrator',
            'password_computer' => Hash::make('Admin@123'),
            'photocopy_code' => '0001',
            'email' => 'wittaya.j@better-groups.com',
            'email_password' => Hash::make('Admin@123'),
            'department_id' => $itDepartment->id,
            'express_username' => 'ADMIN01',
            'express_code' => '0001',
            'can_print_color' => true,
            'can_use_vpn' => true,
            'is_active' => true,
            'start_date' => now()->toDateString(),
        ]);

        // สร้าง Super Admin User
        $superAdmin = User::firstOrCreate([
            'email' => 'wittaya.j@better-groups.com'
        ], [
            'name' => 'System Administrator',
            'username' => 'admin',
            'email' => 'wittaya.j@better-groups.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'super_admin',
            'employee_id' => $superAdminEmployee->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // สร้าง IT Admin Employee
        $itAdminEmployee = Employee::firstOrCreate([
            'employee_code' => 'IT002'
        ], [
            'employee_code' => 'IT002',
            'keycard_id' => 'IT002',
            'name_th' => 'ผู้ดูแล',
            'surname_th' => 'ไอที',
            'name_en' => 'IT',
            'surname_en' => 'Admin',
            'nickname' => 'IT Admin',
            'username_computer' => 'it.admin',
            'password_computer' => Hash::make('ITAdmin@123'),
            'photocopy_code' => '0002',
            'email' => 'itadmin@company.com',
            'email_password' => Hash::make('ITAdmin@123'),
            'department_id' => $itDepartment->id,
            'express_username' => 'ITADM01',
            'express_code' => '0002',
            'can_print_color' => true,
            'can_use_vpn' => true,
            'is_active' => true,
            'start_date' => now()->toDateString(),
        ]);

        // สร้าง IT Admin User
        $itAdmin = User::firstOrCreate([
            'email' => 'itadmin@company.com'
        ], [
            'name' => 'IT Administrator',
            'username' => 'itadmin',
            'email' => 'itadmin@company.com',
            'password' => Hash::make('ITAdmin@123'),
            'role' => 'it_admin',
            'employee_id' => $itAdminEmployee->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // สร้าง Demo Employee User
        $hrDepartment = Department::firstOrCreate([
            'name' => 'ฝ่ายบุคคล (HR)'
        ]);

        $demoEmployee = Employee::firstOrCreate([
            'employee_code' => 'HR001'
        ], [
            'employee_code' => 'HR001',
            'keycard_id' => 'HR001',
            'name_th' => 'สมชาย',
            'surname_th' => 'ใจดี',
            'name_en' => 'Somchai',
            'surname_en' => 'Jaidee',
            'nickname' => 'ชาย',
            'username_computer' => 'somchai.jaidee',
            'password_computer' => Hash::make('User@123'),
            'photocopy_code' => '1001',
            'email' => 'somchai@company.com',
            'email_password' => Hash::make('User@123'),
            'department_id' => $hrDepartment->id,
            'express_username' => 'SOMCH01',
            'express_code' => '1001',
            'can_print_color' => false,
            'can_use_vpn' => false,
            'is_active' => true,
            'start_date' => now()->subMonths(6)->toDateString(),
        ]);

        // สร้าง Demo Employee User
        $demoUser = User::firstOrCreate([
            'email' => 'somchai@company.com'
        ], [
            'name' => 'สมชาย ใจดี',
            'username' => 'somchai',
            'email' => 'somchai@company.com',
            'password' => Hash::make('User@123'),
            'role' => 'employee',
            'employee_id' => $demoEmployee->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Users seeded successfully!');
        $this->command->info('Super Admin: wittaya.j@better-groups.com / Admin@123');
        $this->command->info('IT Admin: itadmin@company.com / ITAdmin@123');
        $this->command->info('Employee: somchai@company.com / User@123');
    }
}