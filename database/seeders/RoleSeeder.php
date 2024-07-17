<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
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
                'ref' => Role::ROLES['superadmin'],
                'role' => 'Superadmin'
            ],
            [
                'ref' => Role::ROLES['moderator'],
                'role' => 'Moderator'
            ],
            [
                'ref' => Role::ROLES['participant'],
                'role' => 'Participant'
            ],
        ];

        Role::insert($arr);
    }
}
