<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminAcc = [
            [
                'username' => 'Muhammad Adnan',
                'email' => 'adnn.ngr@gmail.com',
                'password' => bcrypt('1'),
            ],
            [
                'username' => 'Muhammad Riski Aulia',
                'email' => 'fvan9318@gmail.com',
                'password' => bcrypt('Admin#123'),
            ],
            [
                'username' => 'Ryo Faiz',
                'email' => 'ryofaiz664@gmail.com',
                'password' => bcrypt('Admin#123'),
            ],
            [
                'username' => 'Fatih dafa',
                'email' => 'fatihdaffa2008@gmail.com',
                'password' => bcrypt('Admin#123')
            ]
        ];

        foreach($adminAcc as $key => $val){
            User::create($val);
        }
    }
}
