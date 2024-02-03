<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusList = [
            ['name' => 'Ouvert'],
            ['name' => 'Fermé'],
            ['name' => 'Recrute'],
        ];
        foreach ($statusList as $status) {
            Status::firstOrCreate($status);
        }
    }
}
