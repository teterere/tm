<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'Andris Bērziņš',
            'Jānis Kalniņš',
            'Anna Ozola',
            'Pēteris Adamsons',
            'Māra Meiere',
            'Dainis Vilsons',
            'Ilze Jākobsone',
            'Rūdolfs Krūmiņš',
            'Zane Rudzīte',
            'Helēna Grīnberga'
        ];

        foreach ($users as $name) {
            User::factory()->create([
                'company_id' => DatabaseSeeder::$targetCompany,
                'name'       => $name,
                'avatar'     => Str::slug($name) . '.jpg'
            ]);
        }
    }
}
