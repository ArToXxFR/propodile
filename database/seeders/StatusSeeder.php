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
        $status_list = [
            ['name' => 'Ouvert'],
            ['name' => 'Fermé'],
            ['name' => 'Recrute'],
        ];
        Status::insert($status_list);
    }
}
