<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\{Article};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * @var User
         */
        $u = User::factory()->create(
            [
                'name' => 'System Admin',
                'email' => 'systemadmin@demo.com',
                'password' => Hash::make('abcd1234')
            ]
        );
        $u->assignRole('System Admin');
        $u = User::factory()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@demo.com',
                'password' => Hash::make('abcd1234')
            ]
        );
        $u->assignRole('Admin');

        User::factory()
        ->count(10) // Create 10 users
        ->has(Article::factory()->forUser()->count(5)) // Each user has 5 articles
        ->create();
    }
}
