<?php

require_once 'db_connect.php';

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$truncate = 'TRUNCATE ads';

$dbc->exec($truncate);

$categories = array(
    'Accounting and Finance',
    'Admin and Office',
    'Appliances',
    'Art/Media/Design',
    'Arts and Crafts',
    'Auto Parts',
    'Automotive',
    'Baby and kid',
    'Biotech and Science',
    'Books',
    'Business/Mgmt',
    'Cars and Trucks',
    'Computer and Technology',
    'Computers and Electronics',
    'Customer Service',
    'Education',
    'Event',
    'Furniture',
    'Human Resources',
    'Internet Engineers',
    'Legal',
    'Legal/Peralegal',
    'Lessons',
    'Medical/Health',
    'Music',
    'Pet',
    'Real Estate',
    'Realator',
    'Salon/Spa/Fitness',
    'Security',
    'Software/QA/DBA',
    'Sports and Outdoors',
    'Technical Support',
    'Tools',
    'Transport',
    'Video Gaming',
    'Writing/Editing'
    );
  
$ad = [
    'title' => 'toothbrush', 'description' => 'like new', 'image_url' => 'pingpong.jpeg','category' => "$category", 'price' => '5'
];

foreach ($categories as $category) {

    $stmt = $dbc->prepare("INSERT INTO ads(title, description, price, category, image_url)
     VALUES(:title, :description, :price, :category, :image_url)");
    $stmt ->bindValue(':title', $ad['title'], PDO::PARAM_STR);
    $stmt ->bindValue(':description', $ad['description'], PDO::PARAM_STR);
    $stmt ->bindValue(':price', $ad['price'], PDO::PARAM_STR);
    $stmt ->bindValue(':category', $category, PDO::PARAM_STR);
    $stmt ->bindValue(':image_url', $ad['image_url'], PDO::PARAM_STR);
    $stmt->execute();
    echo "Inserted ID: " . $dbc->lastInsertId() . PHP_EOL;
    
}