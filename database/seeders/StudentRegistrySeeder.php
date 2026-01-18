<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentRegistry;

class StudentRegistrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Add your official student list here with their matric numbers and names
     */
    public function run(): void
    {
        $students = [
            ['MatricNo' => 'CB22057', 'Name' => 'MUHAMMAD RUSYDAN BIN MOHAMMED RAIS', 'Department' => 'Computer Science'],
            ['MatricNo' => 'CB22032', 'Name' => 'MUHAMMAD HAZEEQ NAJMUDDIN BIN ROSHIDI', 'Department' => 'Computer Science'],
            ['MatricNo' => 'CB22063', 'Name' => 'NUR SYAHILA BINTI KHARULAZWA', 'Department' => 'Information Technology'],
            ['MatricNo' => 'CB22126', 'Name' => 'MUHAMAD SYARIFUDIN BIN MOHD AZON', 'Department' => 'Computer Science'],
            ['MatricNo' => 'CB22141', 'Name' => 'NUR ALYA SYAKIRAH BINTI NASARUDIN', 'Department' => 'Software Engineering'],
            ['MatricNo' => 'CB22122', 'Name' => 'MUHAMMAD FIKRI BIN SHAHRIL', 'Department' => 'Software Engineering'],
            ['MatricNo' => 'CB22089', 'Name' => 'NURUL AIN BINTI ABD JABAR', 'Department' => 'Software Engineering'],
            ['MatricNo' => 'CB23145', 'Name' => 'MOHAMAD HILMAN NAFIS BIN MOHD AFFENDEY', 'Department' => 'Software Engineering'],
            ['MatricNo' => 'CA22033', 'Name' => 'MUHAMMAD AIMAN BIN TAN', 'Department' => 'Software Engineering'],
            ['MatricNo' => 'CA22074', 'Name' => 'ISMA IWANI BINTI ISMAIL', 'Department' => 'Software Engineering'],

            // Add more students as needed. Format: ['MatricNo' => 'CBXXXXXX', 'Name' => 'Full Name', 'Department' => 'Department']
        ];

        foreach ($students as $student) {
            StudentRegistry::updateOrCreate(
                ['MatricNo' => $student['MatricNo']],
                [
                    'Name' => $student['Name'],
                    'Department' => $student['Department'] ?? null,
                ]
            );
        }

        $this->command->info('Student registry seeded successfully!');
    }
}
