<?php

require_once 'db_connect.php';

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$truncate = 'TRUNCATE ads';

$dbc->exec($truncate);

$ads = [
    ['title' => 'Acadia', 'description' => 'ME', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Arches', 'description' => 'UT', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Badlands', 'description' => 'SD', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Big Bend', 'description' => 'TX', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Carlsbad Caverns', 'description' => 'NM', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Crater Lake', 'description' => 'OR', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Denali', 'description' => 'AL', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Everglades', 'description' => 'FL', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Glacier', 'description' => 'MT', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Olympic', 'description' => 'WA', 'image_url' =>'/img/pingpong.jpeg' ]
];

    $stmt = $dbc->prepare("INSERT INTO ads(title, description, image_url) VALUES(:title,:description,:image_url)");
foreach ($ads as $ad) {
     $stmt ->bindValue(':title', $ad['title'], PDO::PARAM_STR);
     $stmt ->bindValue(':description', $ad['description'], PDO::PARAM_STR);
     $stmt ->bindValue(':image_url', $ad['image_url'], PDO::PARAM_STR);

    $stmt->execute();
}
    echo "Inserted ID: " . $dbc->lastInsertId() . PHP_EOL;
    
