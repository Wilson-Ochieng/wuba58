<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
   {
        User::updateOrCreate(
            ['email' => 'wubahouseinformationtechnology@gmail.com'],
            [
                'name'     => 'Wuba Admin',
                'password' => Hash::make('Wuba#2026'),
            ]
        );
    }
}
