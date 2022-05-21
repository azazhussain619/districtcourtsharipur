<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\User::factory(10)->create();

        $roleAdmin = \App\Models\Role::create([
            'name' => 'admin'
        ]);

        \App\Models\Role::create([
            'name' => 'computer_operator'
        ]);

        \App\Models\Role::create([
            'name' => 'judge'
        ]);

        $designation = \App\Models\Designation::create([
            'name' => 'Computer Operator',
            'category' => 'staff'
        ]);

        $court = \App\Models\Court::create([
           'name' => 'Civil Judge-I'
        ]);

        $user = \App\Models\User::create([
            'name' => 'Syed Azaz Hussain Shah',
            'email' => 'azaz.hussain619@gmail.com',
            'password' => bcrypt('password'),
            'designation_id' => 1,
            'court_id' => 1
        ])->profile()->create();




    }
}
