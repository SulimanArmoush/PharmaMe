<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = 
        [
        [
            'name' => 'Warehouse' //1
        ],
        [
            'name' => 'Pharmacist' //2
        ],
    ];
    Role::insert($role);
}
}