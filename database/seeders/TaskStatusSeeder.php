<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'todo'        => 'Neiesākts',
            'in_progress' => 'Tiek veikts',
            'in_review'   => 'Tiek pārskatīts',
            'done'        => 'Izpildīts'
        ];

        foreach ($statuses as $key => $title) {
            TaskStatus::create([
                'key'   => $key,
                'title' => $title
            ]);
        }
    }
}
