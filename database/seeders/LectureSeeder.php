<?php

namespace Database\Seeders;

use App\Models\Lecture;
use Illuminate\Database\Seeder;

class LectureSeeder extends Seeder
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
                'name' => 'Ir. Laurentius Noer Andoyo, M.T'
            ],
            [
                'name' => 'Dipl. Ing. Indra S., S.H, MBA'
            ],
            [
                'name' => 'Anita, S.Kom, M.T'
            ],
            [
                'name' => 'Dr. Evy Poerbaningtyas, S.Si, M.T'
            ],
            [
                'name' => 'Sugeng Widodo, S.Kom., M.Kom'
            ],
            [
                'name' => 'Jozua F. Palandi, S.Kom., M.Kom'
            ],
            [
                'name' => 'Laila Isyriyah, S.Kom., M.Kom'
            ],
            [
                'name' => 'Dr. Eva Handriyantini, S.Kom, M.MT'
            ],
            [
                'name' => 'Daniel Rudiaman Sijabat, ST., M.Kom'
            ],
            [
                'name' => 'Diah Arifah P., S.Kom, M.T'
            ],
            [
                'name' => 'Setiabudi Sakaria, S.Kom., M.Kom'
            ],
            [
                'name' => 'Subari, S.Kom., M.Kom'
            ],
            [
                'name' => 'Saiful Yahya, S.Sn, M.T'
            ],
            [
                'name' => 'Mukhlis Amien, S.Kom., M.Kom'
            ],
            [
                'name' => 'Meivi Kartikasari, S.Kom.,MT'
            ],
            [
                'name' => 'Koko Wahyu Prasetyo, S.Kom, M.T.I'
            ],
            [
                'name' => 'Mahendra Wibawa, S.Sn, M.Pd'
            ],
            [
                'name' => 'Siti Aminah, S.Si., M.Pd'
            ],
            [
                'name' => 'Nira Radita, S.Pd., M.Pd'
            ],
            [
                'name' => 'Yekti Asmoro Kanthi, S.Si., M.A.B'
            ],
            [
                'name' => 'Chaulina Alfianti Oktavia, S.Kom., M.T'
            ],
            [
                'name' => 'Rachman Hardiansyah, S.p.d., M.P.I'
            ],
            [
                'name' => 'Addin Aditya, S.Kom., M.Kom'
            ],
            [
                'name' => 'Ahmad Zakiy Ramadhan, S.Sn., M.Sn'
            ],
            [
                'name' => 'Febry Eka Purwiantono, S.Kom., M.Kom'
            ],
            [
                'name' => 'Rakhmad Maulidi, M.Kom'
            ],
            [
                'name' => 'Windarini Cahyadiana, S.E., M.M'
            ],
            [
                'name' => 'Rina Nurfitri, S.Pd., M.Pd'
            ],
            [
                'name' => 'Zusana Eko Pudyastuti, S.S, M.Pd'
            ],
            [
                'name' => 'Rahmat Kurniawan, S.Pd.,M.Pd'
            ],
            [
                'name' => 'Bagus Kristomoyo Kristanto, S.Kom., M.MT'
            ],
            [
                'name' => 'Arif Tirtana, S.Kom., M.Kom'
            ],
            [
                'name' => 'Adnan Zulkarnain, S.Kom., M.M.S.I'
            ],
            [
                'name' => 'Adita Ayu Kusumasari, S.Sn., M.Sn'
            ],
            [
                'name' => 'Hilman Nuril Hadi , S.Kom., M.Kom'
            ],
            [
                'name' => 'Triano Nanda Setiabudi, S.Pd., M.Pd'
            ],
        ];

        Lecture::insert($arr);
    }
}
