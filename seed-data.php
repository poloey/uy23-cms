<?php 

require 'vendor/autoload.php';

require 'create-table.php';
use Carbon\Carbon;
use Faker\Factory;

$users = [
  [
  "name" => 'Nur',
  "email" => 'nur@gmail.com'
  ],
  [
  "name" => 'Mahibur',
  "email" => 'mahibur@gmail.com'
  ],
  [
  "name" => 'farhad',
  "email" => 'farhad@gmail.com'
  ],
  [
  "name" => 'Majedul',
  "email" => 'majedul@gmail.com'
  ],
  [
  "name" => 'Tahmina',
  "email" => 'tahmina@gmail.com'
  ],
];

foreach ($users as $user) {
  User::insert([
    "name" => $user['name'],
    "email" => $user['email'],
    "password" => password_hash('secret', PASSWORD_BCRYPT),
    "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
    "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
  ]);
}

$categories = ["Web", "Technology", "PHP", 'Html', 'Css', 'Laravel'];

foreach ($categories as $category) {
  Category::insert([
    'name' => $category,
    "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
    "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
  ]);
}

$faker = Factory::create();
foreach (range(1, 30) as $i) {
  Post::insert([
    'title' => $faker->sentence,
    'content' => $faker->paragraph(rand(15, 30)),
    'user_id' => rand(1, count($users)),
    'category_id' => rand(1, count($categories)),
    "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
    "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
  ]);
}

foreach (range(1, 200) as $i) {
  Comment::insert([
    'name' => $faker->name,
    'email' => $faker->email,
    'text' => $faker->paragraph(rand(1, 4)),
    'post_id' => rand(1, 30),
    "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
    "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
  ]);
}

echo "table created successfully \n";
echo "data seeding successfully";


