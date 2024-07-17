<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'name' => 'Desain Prototype UI-UX',
            ],
            [
                'name' => 'Aplikasi Desktop',
            ],
            [
                'name' => 'Aplikasi Website',
            ],
            [
                'name' => 'Aplikasi Mobile',
            ],
            [
                'name' => 'Aplikasi Game',
            ],
        ];

        Category::insert($arr);
    }
}
