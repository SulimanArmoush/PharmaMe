<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category =
        [
            [
                'catName' => 'syrups', //1
                'image' => 'categories/syrups.jpg'
            ],
            [
                'catName' => 'pills', //2
                'image' => 'categories/pills.jpg'

            ],
            [
                'catName' => 'injections', //3
                'image' => 'categories/injections.jpg'

            ],
            [
                'catName' => 'ointments', //4
                'image' => 'categories/ointments.jpg'

            ],
        ];
        Category::insert($category);
    }
}
