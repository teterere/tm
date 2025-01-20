<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'       => 'Andris Bērziņš',
            'email'      => 'andris.berzins@example.com',
            'password'   => Hash::make('parole123')
        ]);

        $users = [
            'Jānis Kalniņš',
            'Anna Ozola',
            'Pēteris Pētersone',
            'Māra Meiere',
            'Dainis Vilsons',
            'Ilze Jākobsone',
            'Rūdolfs Krūmiņš',
            'Zane Rudzīte'
        ];

        foreach ($users as $user) {
            User::factory()->create([
                'name' => $user
            ]);
        }
    }
}
