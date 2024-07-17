<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
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
                'key' => 'about',
                'value' => 'STIKI TECHNOFEST merupakan pameran produk Tugas Akhir, Tugas Akhir Mata Kuliah, Magang, Lomba, Proyek Individu dan Proyek Karya Kelompok Bidang Minat dari Program studi Teknik Informatika, Sistem Informatika dan Manajemen Informatika',
                'is_css' => null
            ],
            [
                'key' => 'about_en',
                'value' => 'STIKI TECHNOFEST is an exhibition of Final Assignment, Final Course Assignment, Internship, Competition, Individual Project, and Group Project of interest field from Computer Engineering, Information System, and Information Management Program, STIKI Malang.',
                'is_css' => null
            ],
            [
                'key' => 'title',
                'value' => 'STIKI TECHNOFEST 3.0',
                'is_css' => null
            ],
            [
                'key' => 'logo',
                'value' => '',
                'is_css' => null
            ],
            [
                'key' => 'logo_home',
                'value' => '',
                'is_css' => null
            ],
            [
                'key' => 'event_start',
                'value' => '',
                'is_css' => null
            ],
            [
                'key' => 'event_end',
                'value' => '',
                'is_css' => null
            ],
            [
                'key' => 'allow_upload',
                'value' => 1,
                'is_css' => null
            ],
            [
                'key' => 'custom_css',
                'value' => "#about > div.anim-icons.full-width { background-color:lime;}",
                'is_css' => null
            ],
            [
                'key' => 'style_btn_style_one',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_info_box',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_image_box',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_scroll_to_top',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_selection',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_btn_box',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_pagination',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_footer',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_page_title',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_btn_style_two',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_scroll_to_top_hover',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_btn_style_two_hover',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_navigation_hover_1',
                'value' => null,
                'is_css' => 1
            ],
            [
                'key' => 'style_navigation_hover_2',
                'value' => null,
                'is_css' => 1
            ]
        ];

        Setting::insert($arr);
    }
}
