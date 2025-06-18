<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@medicare.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dr. Sarah Wilson',
            'username' => 'staff1',
            'email' => 'sarah@medicare.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'staff_id' => 'STF001',
            'total_fees' => 750000,
        ]);

        User::create([
            'name' => 'Nurse Johnson',
            'username' => 'staff2',
            'email' => 'johnson@medicare.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'staff_id' => 'STF002',
            'total_fees' => 450000,
        ]);

        // Create Patients
        Patient::create([
            'nik' => '3201234567890123',
            'name' => 'John Doe',
            'date_of_birth' => '1985-06-15',
            'phone' => '+1234567890',
        ]);

        Patient::create([
            'nik' => '3201234567890124',
            'name' => 'Jane Smith',
            'date_of_birth' => '1990-03-22',
            'phone' => '+1234567891',
        ]);

        // Create Services
        Service::create([
            'name' => 'General Consultation',
            'price' => 150000,
            'staff_fee' => 50000,
            'profit' => 100000,
        ]);

        Service::create([
            'name' => 'Blood Test',
            'price' => 200000,
            'staff_fee' => 30000,
            'profit' => 170000,
        ]);

        Service::create([
            'name' => 'X-Ray',
            'price' => 300000,
            'staff_fee' => 75000,
            'profit' => 225000,
        ]);

        // Create Products
        Product::create([
            'name' => 'Paracetamol 500mg',
            'stock' => 15,
            'selling_price' => 25000,
            'cost_price' => 15000,
            'profit' => 10000,
        ]);

        Product::create([
            'name' => 'Amoxicillin 250mg',
            'stock' => 3,
            'selling_price' => 45000,
            'cost_price' => 30000,
            'profit' => 15000,
        ]);

        Product::create([
            'name' => 'Vitamin C 1000mg',
            'stock' => 25,
            'selling_price' => 35000,
            'cost_price' => 20000,
            'profit' => 15000,
        ]);
    }
}