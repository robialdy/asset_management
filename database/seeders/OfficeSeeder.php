<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Head Office', 'Branch Office', 'Agent', 'Warehouse'];
        $statuses = ['Active', 'Inactive'];

        for ($i = 1; $i <= 10; $i++) {
            DB::table('office')->insert([
                'name' => 'Office ' . $i,
                'slug' => Str::slug("Office $i", '-'),
                'category' => $categories[array_rand($categories)], // Random category
                'address' => 'Address ' . Str::random(10),
                'status' => $statuses[array_rand($statuses)], // Random status
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
