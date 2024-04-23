<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission =
        [
            [
                'name' => 'Warehouse-register', //1
            ],
            [
                'name' => 'Pharmacist-register', //2
            ],
            [
                'name' => 'login', //3
            ],
            [
                'name' => 'logout', //4
            ],
            [
                'name' => 'createMedicines', //5
            ],
            [
                'name' => 'getMedicines', //6
            ],
            [
                'name' => 'getMedicinesOwner', //7
            ],
            [
                'name' => 'getMedicineId', //8
            ],
            [
                'name' => 'search', //9
            ],
            [
                'name' => 'getCatMedicines', //10
            ],
            [
                'name' => 'getCategories', //11
            ],
            [
                'name' => 'getCatOwner', //12
            ],
            [
                'name' => 'createOrder', //13
            ],
            [
                'name' => 'getUserOrders', //14
            ],
            [
                'name' => 'getOrders', //15
            ],
            [
                'name' => 'getSingleOrder', //16
            ],
            [
                'name' => 'updateStatus', //17
            ],
            [
                'name' => 'updatePaymentStatus', //18
            ],
            [
                'name' => 'getUsers', //19
            ],
            [
                'name' => 'addToFav', //20
            ],
            [
                'name' => 'getFavs', //21
            ],
            [
                'name' => 'getUserInfo', //22
            ],
            [
                'name' => 'getMyMedicines', //23
            ],
            [
                'name' => 'phSearch', //24
            ],
            [
                'name' => 'getMedicineSalesReport', //25
            ],
        ];
        Permission::insert($permission);
    }
}
