<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'men\'s clothing',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'jewelery',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'electronics',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'women\'s clothing',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
