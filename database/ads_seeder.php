<?php

require_once 'db_connect.php';

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$truncate = 'TRUNCATE ads';

$dbc->exec($truncate);

$ads = [
    ['title' => 'Acadia', 'description' => 'ME', 'image_url' => 'pingpong.jpeg', 'category' => 'Auto Parts', 'price' => '0'],
    ['title' => 'Arches', 'description' => 'UT', 'image_url' => 'pingpong.jpeg', 'category' => 'Baby and Kid', 'price' => '0'],
    ['title' => 'Badlands', 'description' => 'SD', 'image_url' => 'pingpong.jpeg', 'category' => 'Cars and Trucks', 'price' => '0'],
    ['title' => 'Big Bend', 'description' => 'TX', 'image_url' => 'pingpong.jpeg', 'category' => 'Computer and Electronics', 'price' => '0'],
    ['title' => 'Carlsbad Caverns', 'description' => 'NM', 'image_url' => 'pingpong.jpeg', 'category' => 'Tools', 'price' => '0'],
    ['title' => 'Crater Lake', 'description' => 'OR', 'image_url' => 'pingpong.jpeg', 'category' => 'Sports and Outdoors', 'price' => '0'],
    ['title' => 'Denali', 'description' => 'AL', 'image_url' => 'pingpong.jpeg', 'category' => 'Music', 'price' => '0'],
    ['title' => 'Everglades', 'description' => 'FL', 'image_url' => 'pingpong.jpeg', 'category' => 'Furniture', 'price' => '0'],
    ['title' => 'Glacier', 'description' => 'MT', 'image_url' => 'pingpong.jpeg', 'category' => 'Video Gaming', 'price' => '0'],
    ['title' => 'Olympic', 'description' => 'WA', 'image_url' =>'pingpong.jpeg', 'category' => 'Appliances', 'price' => '0']
];

    $stmt = $dbc->prepare("INSERT INTO ads(title, description, price, image_url) VALUES(:title, :description, :price, :image_url)");
foreach ($ads as $ad) {
     $stmt ->bindValue(':title', $ad['title'], PDO::PARAM_STR);
     $stmt ->bindValue(':description', $ad['description'], PDO::PARAM_STR);
     $stmt ->bindValue(':price', $ad['price'], PDO::PARAM_STR);
     $stmt ->bindValue(':image_url', $ad['image_url'], PDO::PARAM_STR);

    $stmt->execute();
}
    echo "Inserted ID: " . $dbc->lastInsertId() . PHP_EOL;
    