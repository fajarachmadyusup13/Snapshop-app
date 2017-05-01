<?php

use Snapshop\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super admin',
                'display_name' => 'Super Administrator',
                'description' => 'User has access to all system functionality'
            ],
            [
                'name' => 'admin',
                'display_name' => 'admin',
                'description' => 'User can create create data in the system'
            ]
        ];

        foreach ($roles as $key => $value) {
            Role::create($value);
        }
    }
}
