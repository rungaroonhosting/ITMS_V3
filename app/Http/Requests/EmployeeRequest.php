<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee') ? $this->route('employee')->id : null;
        
        return [
            // Basic Info
            'employee_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('employees')->ignore($employeeId)->whereNull('deleted_at')
            ],
            'first_name_th' => 'required|string|max:100',
            'last_name_th' => 'required|string|max:100',
            'first_name_en' => 'nullable|string|max:100',
            'last_name_en' => 'nullable|string|max:100',
            'nickname' => 'nullable|string|max:50',
            
            // Contact Info
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('employees')->ignore($employeeId)->whereNull('deleted_at')
            ],
            'phone' => 'nullable|string|max:20',
            'login_email' => 'nullable|email|max:255',
            
            // Organization
            'department_id' => 'required|exists:departments,id',
            'branch_id' => 'nullable|exists:branches,id',
            'position' => 'nullable|string|max:100',
            
            // System Access
            'role' => 'required|in:super_admin,it_admin,hr,employee,express',
            'status' => 'required|in:active,inactive',
            
            // Passwords
            'login_password' => $this->isMethod('POST') ? 'nullable|string|min:6|max:255' : 'nullable|string|min:6|max:255',
            'computer_password' => 'nullable|string|max:255',
            'email_password' => 'nullable|string|max:255',
            
            // Express System
            'express_username' => [
                'nullable',
                'string',
                'max:7',
                Rule::unique('employees')->ignore($employeeId)->whereNull('deleted_at')
            ],
            'express_password' => [
                'nullable',
                'string',
                'size:4',
                'regex:/^[0-9]{4}$/',
                Rule::unique('employees')->ignore($employeeId)->whereNull('deleted_at')
            ],
            
            // Permissions
            'vpn_access' => 'nullable|boolean',
            'color_printing' => 'nullable|boolean',
            'remote_work' => 'nullable|boolean',
            'admin_access' => 'nullable|boolean',
            
            // Photo
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048|dimensions:min_width=50,min_height=50,max_width=2000,max_height=2000',
            'delete_photo' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_code.required' => 'กรุณาระบุรหัสพนักงาน',
            'employee_code.unique' => 'รหัสพนักงานนี้มีในระบบแล้ว',
            'first_name_th.required' => 'กรุณาระบุชื่อ (ภาษาไทย)',
            'last_name_th.required' => 'กรุณาระบุนามสกุล (ภาษาไทย)',
            'email.required' => 'กรุณาระบุอีเมล',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique' => 'อีเมลนี้มีในระบบแล้ว',
            'department_id.required' => 'กรุณาเลือกแผนก',
            'department_id.exists' => 'แผนกที่เลือกไม่มีในระบบ',
            'branch_id.exists' => 'สาขาที่เลือกไม่มีในระบบ',
            'role.required' => 'กรุณาเลือกบทบาท',
            'role.in' => 'บทบาทที่เลือกไม่ถูกต้อง',
            'status.required' => 'กรุณาเลือกสถานะ',
            'status.in' => 'สถานะที่เลือกไม่ถูกต้อง',
            'login_password.min' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
            'express_username.max' => 'Express Username ต้องไม่เกิน 7 ตัวอักษร',
            'express_username.unique' => 'Express Username นี้มีในระบบแล้ว',
            'express_password.size' => 'Express Password ต้องเป็นตัวเลข 4 หลัก',
            'express_password.regex' => 'Express Password ต้องเป็นตัวเลขเท่านั้น',
            'express_password.unique' => 'Express Password นี้มีในระบบแล้ว',
            'photo.image' => 'ไฟล์ต้องเป็นรูปภาพเท่านั้น',
            'photo.mimes' => 'รองรับเฉพาะ JPEG, JPG, PNG, GIF',
            'photo.max' => 'ขนาดไฟล์ต้องไม่เกิน 2MB',
            'photo.dimensions' => 'ขนาดรูปต้องอยู่ระหว่าง 50x50 ถึง 2000x2000 pixels',
        ];
    }

    public function attributes(): array
    {
        return [
            'employee_code' => 'รหัสพนักงาน',
            'first_name_th' => 'ชื่อ (ไทย)',
            'last_name_th' => 'นามสกุล (ไทย)',
            'first_name_en' => 'ชื่อ (English)',
            'last_name_en' => 'นามสกุล (English)',
            'nickname' => 'ชื่อเล่น',
            'email' => 'อีเมล',
            'phone' => 'เบอร์โทร',
            'department_id' => 'แผนก',
            'branch_id' => 'สาขา',
            'position' => 'ตำแหน่ง',
            'role' => 'บทบาท',
            'status' => 'สถานะ',
            'photo' => 'รูปภาพ',
        ];
    }
}