<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $data = array(
            'name'=>'Super Admin',
            'email'=>'super@admin.com',
            'password'=> bcrypt('superAdmin'),
            'is_super'=> 1
        );
        User::create($data);
    }
}
