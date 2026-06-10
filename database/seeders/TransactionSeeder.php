<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaction')->insert([
            [
                'user_id' => 1,
                'doctor_id' => 1,
                'service_type' => 'Consultation',
                'transaction_date' => Carbon::now()->subDays(2),
                'amount' => 150000,
                'status' => 'completed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'doctor_id' => 2,
                'service_type' => 'Skin Check',
                'transaction_date' => Carbon::now()->subDays(1),
                'amount' => 200000,
                'status' => 'completed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 3,
                'doctor_id' => 3,
                'service_type' => 'Vaccination',
                'transaction_date' => Carbon::now(),
                'amount' => 100000,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
