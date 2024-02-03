<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gradeList = [
            ['name' => 'Socle numérique 1'],
            ['name' => 'Socle numérique 2'],
            ['name' => 'Bachelor'],
            ['name' => 'Ingénierie 1'],
            ['name' => 'Ingénierie 2'],
            ['name' => 'Autre...'],
        ];

        foreach ($gradeList as $gradeData) {
            Grade::firstOrCreate($gradeData);
        }
    }
}
