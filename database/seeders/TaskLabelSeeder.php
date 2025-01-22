<?php

namespace Database\Seeders;

use App\Models\TaskLabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labels = [
            [
                'key' => 'design',
                'title' => 'Dizains',
                'color' => '#bde0fe'
            ],
            [
                'key' => 'frontend',
                'title' => 'Frontend',
                'color' => '#e9edc9'
            ],
            [
                'key' => 'backend',
                'title' => 'Backend',
                'color' => '#faedcd'
            ],
            [
                'key' => 'research',
                'title' => 'Izpēte',
                'color' => '#fcd5ce'
            ],
            [
                'key' => 'dev_ops',
                'title' => 'DevOps',
                'color' => '#d8f3dc'
            ],
            [
                'key' => 'bug',
                'title' => 'Bug',
                'color' => '#cbc0d3'
            ],
            [
                'key' => 'documentation',
                'title' => 'Dokumentācija',
                'color' => '#d9d9d9'
            ]
        ];

        foreach ($labels as $data) {
            TaskLabel::create($data);
        }
    }
}
