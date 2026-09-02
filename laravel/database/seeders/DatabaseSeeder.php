<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!Setting::find(1)) {
            Setting::create([
                'sitename' => 'CargoLink',
                'site_title' => 'logistics',
                'site_url' => 'https://www.cargolink.com',
                'tracking_num' => '0987654321',
                'email_name' => 'CargoLink',
                'email_address' => 'CargoLink@gmail.com',
                'site_currency' => '$',
            ]);
        }

        if (!Admin::where('email', 'admin@mail.com')->exists()) {
            Admin::create([
                'email' => 'admin@mail.com',
                'password' => Hash::make('123456'),
            ]);
        }
    }
}
