<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;                

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articles')->insert([
            [
                'title' => 'Tips Jaga Kesehatan Jantung',
                'content' => 'Jaga pola makan sehat dan olahraga rutin...',
                'doctor_id' => 1, // relasi ke Dr. Andi Santoso
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Perawatan Kulit Sensitif',
                'content' => 'Gunakan produk hypoallergenic dan hindari paparan sinar matahari langsung...',
                'doctor_id' => 2, // relasi ke Dr. Siti Rahma
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Nutrisi untuk Balita',
                'content' => 'Pastikan anak mendapatkan protein, vitamin, dan mineral yang cukup...',
                'doctor_id' => 3, // relasi ke Dr. Budi Hartono
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
