<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'role' => 'staff',
        ]);
        
        User::factory()->create([
            'name' => 'Budi Gunawan',
            'email' => 'budi.intern@example.com',
            'role' => 'intern',
        ]);

        User::factory(4)->create([
            'role' => 'intern'
        ]);

        $this->call([
            JobInternSeeder::class,
            InternAttendSeeder::class,
            CallOfDutySeeder::class,
        ]);
    }
}