<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ImportLegacyDataSeeder::class);
        $this->call(ImportTrackingSeeder::class);

        if (!Admin::where('email', 'admin@mail.com')->exists()) {
            Admin::create([
                'email' => 'admin@mail.com',
                'password' => Hash::make('123456'),
            ]);
        }
    }
}
