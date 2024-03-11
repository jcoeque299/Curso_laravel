<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(["name"=> "administrador"]);
        $userRole = Role::create(["name"=> "usuario"]);

        $adminRole->givePermissionTo('seeTickets');
    }
}
