<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
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
                'role_id' => Role::ref(1)->first()->id,
                'name' => 'SuperAdmin',
                'email' => 'superadmin@technofest.stiki.ac.id',
                'password' => bcrypt('password123!'),
                'nrp' => null,
                'college_origin' => null,
                'telephone' => 31337
            ],
            [
                'role_id' => Role::ref(2)->first()->id,
                'name' => 'Moderator',
                'email' => 'moderator@technofest.stiki.ac.id',
                'password' => bcrypt('password123!'),
                'nrp' => null,
                'college_origin' => null,
                'telephone' => 31337
            ],
            [
                'role_id' => Role::ref(3)->first()->id,
                'name' => 'Peserta',
                'email' => 'peserta@technofest.stiki.ac.id',
                'password' => bcrypt('password123!'),
                'nrp' => 31338,
                'college_origin' => null,
                'telephone' => 31337
            ]
        ];
        
        User::insert($arr);
        User::factory()->count(50)->create();
    }
}
