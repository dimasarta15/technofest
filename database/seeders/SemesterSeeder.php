<?php

namespace Database\Seeders;

use App\Models\Semester;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            [
                'semester' => 'Ganjil 2020/2021',
                'title' => 'TECHNOFEST 1.0',
                'position' => 1,
                'status' => 1,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'semester' => 'Genap 2020/2021',
                'title' => 'TECHNOFEST 2.0',
                'position' => 2,
                'status' => 1,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'semester' => 'Genap 2021/2022',
                'title' => 'TECHNOFEST 3.0',
                'position' => 3,
                'status' => 1,
                'created_at' => Carbon::now()->toDateTimeString()
            ]
        ];
        Semester::insert($arr);
    }
}
