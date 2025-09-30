<?php

namespace Database\Seeders;

use App\Models\JobIntern;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobInternSeeder extends Seeder
{
    public function run(): void
    {
        $allInterns = User::where('role', 'intern')->get();
        $budi = User::where('email', 'budi.intern@example.com')->first();

        $tasks = [
            ['task' => 'Design UI / UX', 'description' => 'Membuat desain antarmuka untuk panel admin.', 'status' => 'Done'],
            ['task' => 'Database Sistem', 'description' => 'Merancang dan mengelola alur kerja database.', 'status' => 'Pending'],
            ['task' => 'Frontend', 'description' => 'Mengimplementasikan desain ke dalam kode React.js.', 'status' => 'Pending'],
            ['task' => 'API Integration', 'description' => 'Menghubungkan frontend dengan backend API.', 'status' => 'Done'],
        ];

        if ($budi) {
            foreach ($tasks as $task) {
                JobIntern::create([
                    'user_id' => $budi->id,
                    'created' => today('Asia/Kuala_Lumpur')->isoFormat('dddd, DD MMMM Y'),
                    'task' => $task['task'],
                    'description' => $task['description'],
                    'deadline' => now()->addDays(rand(5, 20))->toDateString(),
                    'status' => $task['status'],
                ]);
            }
        }
        
        foreach ($allInterns->where('id', '!=', $budi?->id) as $intern) {
             JobIntern::create([
                'user_id' => $intern->id,
                'created' => today('Asia/Kuala_Lumpur')->isoFormat('dddd, DD MMMM Y'),
                'task' => 'General Task for ' . $intern->name,
                'description' => 'Randomly assigned general task.',
                'deadline' => now()->addDays(rand(5, 20))->toDateString(),
                'status' => ['Pending', 'Done'][rand(0, 1)],
            ]);
        }
    }
}