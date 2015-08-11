<?php

require_once 'db_connect.php';

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$truncate = 'TRUNCATE ads';

$dbc->exec($truncate);

$ads = [
    ['title' => 'Acadia', 'description' => 'ME', 'date_created' => '1919-02-26', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Arches', 'description' => 'UT', 'date_created' => '1988-10-31', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Badlands', 'description' => 'SD', 'date_created' => '1978-11-10', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Big Bend', 'description' => 'TX', 'date_created' => '1944-06-12', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Carlsbad Caverns', 'description' => 'NM', 'date_created' => '1930-05-14', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Crater Lake', 'description' => 'OR', 'date_created' => '1902-05-22', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Denali', 'description' => 'AL', 'date_created' => '1917-02-26', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Everglades', 'description' => 'FL', 'date_created' => '1934-05-30', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Glacier', 'description' => 'MT', 'date_created' => '1910-05-11', 'image_url' => '/img/pingpong.jpeg'],
    ['title' => 'Olympic', 'description' => 'WA', 'date_created' => '1938-06-29', 'image_url' =>'/img/pingpong.jpeg' ]
];

    $stmt = $dbc->prepare("INSERT INTO ads(title, description, date_created, image_url) VALUES(:title,:description,:date_created,:image_url)");
foreach ($ads as $ad) {
     $stmt ->bindValue(':title', $ad['title'], PDO::PARAM_STR);
     $stmt ->bindValue(':description', $ad['description'], PDO::PARAM_STR);
     $stmt ->bindValue(':date_created', $ad['date_created'], PDO::PARAM_STR);
     $stmt ->bindValue(':image_url', $ad['image_url'], PDO::PARAM_STR);

    $stmt->execute();
}
    echo "Inserted ID: " . $dbc->lastInsertId() . PHP_EOL;
    
