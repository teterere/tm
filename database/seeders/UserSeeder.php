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
        User::factory()->create([
            'name'     => 'Andris Bērziņš',
            'email'    => 'andris.berzins@example.com',
            'password' => Hash::make('parole123'),
            'avatar'   => 'andris-berzins.jpg'
        ]);

        $users = [
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
                'name'   => $name,
                'avatar' => Str::slug($name) . '.jpg'
            ]);
        }
    }
}
