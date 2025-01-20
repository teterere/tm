<?php

namespace Database\Seeders;

use App\Models\TaskPriority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            'low'    => 'Zema',
            'medium' => 'Vidēja',
            'high'   => 'Augsta'
        ];

        foreach ($priorities as $key => $title) {
            TaskPriority::create([
                'title' => $title,
                'key'   => $key
            ]);
        }
    }
}
