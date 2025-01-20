<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Company::create([
            'title' => 'Uzņēmums ABC'
        ]);

        $this->call([
            UserSeeder::class,
            TaskPrioritySeeder::class,
            TaskSeeder::class
        ]);
    }
}
