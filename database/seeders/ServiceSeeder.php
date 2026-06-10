<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
           [
            'service_name' => 'Konsultasi Dokter Online',
            'description'  => 'Layanan konsultasi kesehatan secara online dengan dokter umum untuk membantu menjawab berbagai keluhan',
            'availability' => '08.00 - 21.00',
            'category_id'  => 1,
            'price'        => 50000,
            ]
        ]);
    }
}
