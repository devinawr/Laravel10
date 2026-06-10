<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('doctors')->insert([
            [
                'name' => 'Dr. Andi Santoso',
                'specialization' => 'Cardiology',
                'email' => 'andi.santoso@example.com',
                'phone' => '081234567890',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Dr. Siti Rahma',
                'specialization' => 'Dermatology',
                'email' => 'siti.rahma@example.com',
                'phone' => '082345678901',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Dr. Budi Hartono',
                'specialization' => 'Pediatrics',
                'email' => 'budi.hartono@example.com',
                'phone' => '083456789012',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
