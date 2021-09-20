<?php

namespace Database\Seeders;

use App\Models\Service\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(Category::CATEGORY) ; $i++) {
            Category::create([
                'name'  => Category::CATEGORY[$i],
            ]);
        }
    }
}
