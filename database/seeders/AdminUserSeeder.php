<?php

namespace Database\Seeders;

use App\Models\User;
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
            [
                'name' => 'Laurens'
            ],
            [
                'name' => 'Laurens',
                'email' => 'l.samshuijzen@uu.nl',
                'password' => Hash::make('testtest')
            ]
        );
    }
}
