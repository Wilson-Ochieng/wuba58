<?php

namespace Database\Seeders;
use App\Models\User;                                    // ← ADD
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
                'name' => 'Wuba Admin',
                'password' => Hash::make('Wuba#2026'),
            ]
        );
    }
}
