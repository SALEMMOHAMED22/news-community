<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Admin::create([
            "name" => "admin name",
            "email" => "admin@gmail.com",
            "username" => "admin username",
            "role_id" => 1,
            "password" => bcrypt('adminadmin'),
        ]);
    }
}
