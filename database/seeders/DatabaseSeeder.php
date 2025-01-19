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
        $company = Company::create([
            'title' => 'Uzņēmums ABC'
        ]);

        User::factory()->create([
            'name'       => 'Andris Bērziņš',
            'email'      => 'andris.berzins@example.com',
            'company_id' => $company->id,
            'password'   => Hash::make('parole123')
        ]);
    }
}
