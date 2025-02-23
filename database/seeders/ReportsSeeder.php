<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportsSeeder extends Seeder
{
    public function run(): void
    {
        Report::factory()->count(50)->create();
    }
}
