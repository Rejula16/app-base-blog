<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AppSettingSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SystemPermissionsSeeder::class);
        $this->call(SystemRolesSeeder::class);
        $this->call(AppSettingSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(HashTagSeeder::class);
        $this->call(UserSeeder::class);
    }
}
