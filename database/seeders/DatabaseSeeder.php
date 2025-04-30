<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public static ?Company $targetCompany = null;

    public function run(): void
    {
        self::$targetCompany = self::$targetCompany ?? Company::create([
            'title' => 'Uzņēmums ABC',
        ]);

        $this->call([
            UserSeeder::class,
            TaskStatusSeeder::class,
            TaskLabelSeeder::class,
            TaskPrioritySeeder::class,
            TaskSeeder::class
        ]);
    }
}
