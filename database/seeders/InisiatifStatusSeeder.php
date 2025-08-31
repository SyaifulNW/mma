<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inisiatif;

class InisiatifStatusSeeder extends Seeder
{
    public function run(): void
    {
        // Set semua inisiatif lama status = 0
        Inisiatif::whereNull('status')->update(['status' => 0]);
    }
}
