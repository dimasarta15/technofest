<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryDkvSeeder extends Seeder
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
                'name' => 'Cetak Grafis'
            ],
            [
                'name' => 'Desain Prototype UIUX'
            ],
            [
                'name' => 'Desain Kemasan'
            ],
            [
                'name' => 'Fotografi'
            ],
            [
                'name' => 'Fotografi '
            ],
            [
                'name' => 'Gambar'
            ],
            [
                'name' => 'Gramatika Visual '
            ],
            [
                'name' => 'Komik '
            ],
            [
                'name' => 'Komputer Grafis 2D'
            ],
            [
                'name' => 'Ekperimen Media Grafis 3D'
            ],
            [
                'name' => 'Karya Kemasan'
            ],
            [
                'name' => 'Eksperiman Media Grafis Eco P'
            ],
            [
                'name' => 'Ilustrasi'
            ],
            [
                'name' => 'Multimedia'
            ],
            [
                'name' => 'Animasi 3D'
            ],
            [
                'name' => 'Animasi 2D'
            ],
            [
                'name' => 'Nirmana 2D'
            ],
            [
                'name' => 'Nirmana 2(3D)'
            ],
            [
                'name' => 'PKWU'
            ],
            [
                'name' => 'Aplikasi Website'
            ],
            [
                'name' => 'Aplikasi Mobile'
            ],
            [
                'name' => 'Aplikasi Desktop'
            ],
            [
                'name' => 'Penunjang Paska Pruduksi'
            ],
            [
                'name' => 'Pasca Videografi'
            ],
            [
                'name' => 'Rancang Portofolio '
            ],
            [
                'name' => 'Rancang Visual Identitas '
            ],
            [
                'name' => 'Rancangan Visual Persuatif'
            ],
            [
                'name' => 'Rancangan Visual Informasi'
            ],
            [
                'name' => 'Tinjauan Desain '
            ],
            [
                'name' => 'Typografi 2D'
            ],
            [
                'name' => 'Vidiografi'
            ],
            [
                'name' => 'UI-UX'
            ],
        ];

        Category::insert($arr);
    }
}
