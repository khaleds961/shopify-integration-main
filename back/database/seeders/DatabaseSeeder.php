<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Khaled Houssein',
            'email' => 'khaledalhoussein@gmail.com',
            'password' => Hash::make('123456')
        ]);

        $faker = Faker::create();

        $kitchenToolkits = [
            [
                "name" => "Knife Set",
                "description" => $faker->sentence(10),
                "price" => $faker->randomFloat(2, 10, 200),
                "inventory" => $faker->numberBetween(1, 50),
                "sku" => $faker->unique()->lexify('???????'),
                "image" => "https://images.unsplash.com/photo-1507648154934-f230d5bd6942?q=80&w=1395&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            ],
            [
                "name" => "Kitchen Utensils",
                "description" => $faker->sentence(10),
                "price" => $faker->randomFloat(2, 10, 200),
                "inventory" => $faker->numberBetween(1, 50),
                "sku" => $faker->unique()->lexify('???????'),
                "image" => "https://plus.unsplash.com/premium_photo-1664007654191-75992ed6627b?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            ],
            [
                "name" => "Cooking Pots and Pans",
                "description" => $faker->sentence(10),
                "price" => $faker->randomFloat(2, 10, 200),
                "inventory" => $faker->numberBetween(1, 50),
                "sku" => $faker->unique()->lexify('???????'),
                "image" => "https://images.unsplash.com/photo-1518291344630-4857135fb581?q=80&w=1469&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            ],
            [
                "name" => "Cutting Board Set",
                "description" => $faker->sentence(10),
                "price" => $faker->randomFloat(2, 10, 200),
                "inventory" => $faker->numberBetween(1, 50),
                "sku" => $faker->unique()->lexify('???????'),
                "image" => "https://plus.unsplash.com/premium_photo-1671538298886-18ed2482533e?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            ],
            [
                "name" => "Cooking Tools",
                "description" => $faker->sentence(10),
                "price" => $faker->randomFloat(2, 10, 200),
                "inventory" => $faker->numberBetween(1, 50),
                "sku" => $faker->unique()->lexify('???????'),
                "image" => "https://images.unsplash.com/photo-1626502880734-a15f343afb44?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            ],
            [
                "name" => "Kitchen Knife Set",
                "description" => $faker->sentence(10),
                "price" => $faker->randomFloat(2, 10, 200),
                "inventory" => $faker->numberBetween(1, 50),
                "sku" => $faker->unique()->lexify('???????'),
                "image" => "https://plus.unsplash.com/premium_photo-1726729339060-c35947b01c28?q=80&w=1480&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            ]
        ];

        foreach ($kitchenToolkits as $toolkit) {
            Product::create([
                'user_id' => 1,
                'name' => $toolkit['name'],
                'description' => $toolkit['description'],
                'price' => $toolkit['price'],
                'inventory' => $toolkit['inventory'],
                'sku' => $toolkit['sku'],
                'image' => $toolkit['image'],
                'vendor' => $faker->company,
                'is_pushed' => false,
            ]);
        }
    }
}
