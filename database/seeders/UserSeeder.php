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
            'name'     => 'Andris Bērziņš',
            'email'    => 'andris.berzins@example.com',
            'password' => Hash::make('parole123'),
            'avatar'   => 'andris-berzins.jpg'
        ]);

        $users = [
            'Jānis Kalniņš'    => 'janis-kalnins.jpg',
            'Anna Ozola'       => 'anna-ozola.jpg',
            'Pēteris Adamsons' => 'peteris-adamsons.jpg',
            'Māra Meiere'      => 'mara-meiere.jpg',
            'Dainis Vilsons'   => 'dainis-vilsons.jpg',
            'Ilze Jākobsone'   => 'ilze-jakabsone.jpg',
            'Rūdolfs Krūmiņš'  => 'rudolfs-krumins.jpg',
            'Zane Rudzīte'     => 'zane-rudzite.jpg',
            'Helēna Grīnberga' => 'helena-grinberga.jpg'
        ];

        foreach ($users as $name => $avatar) {
            User::factory()->create([
                'name'   => $name,
                'avatar' => $avatar
            ]);
        }
    }
}
