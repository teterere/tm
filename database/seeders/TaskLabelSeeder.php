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
                'title' => 'Dizains',
                'color' => '#bde0fe'
            ],
            [
                'title' => 'Frontend',
                'color' => '#e9edc9'
            ],
            [
                'title' => 'Backend',
                'color' => '#faedcd'
            ],
            [
                'title' => 'Izpēte',
                'color' => '#fcd5ce'
            ],
            [
                'title' => 'DevOps',
                'color' => '#d8f3dc'
            ],
            [
                'title' => 'Bug',
                'color' => '#cbc0d3'
            ],
            [
                'title' => 'Dokumentācija',
                'color' => '#d9d9d9'
            ]
        ];

        foreach ($labels as $data) {
            TaskLabel::create($data);
        }
    }
}
