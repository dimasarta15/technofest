<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FragmentSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(CategorySeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(LectureSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(SemesterSeeder::class);
        $this->call(CategoryDkvSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
