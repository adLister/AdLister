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
  
<<<<<<< HEAD
$ad = [
    'title' => 'toothbrush', 'description' => 'like new', 'image_url' => 'pingpong.jpeg','category' => "$category", 'price' => '5', 'posting_user' => 'agutie95@yahoo.com'
];
=======
>>>>>>> 05bcd54d6e120c0c9bb1e0bfb92d7f679ecb0cfd

foreach ($categories as $category) {
$ad = [
    'title' => 'toothbrush', 'description' => 'like new', 'image_url' => 'pingpong.jpeg','category' => "$category", 'price' => '5', 'posting_user' => 'rem@gmail.com'
];

    $stmt = $dbc->prepare("INSERT INTO ads(title, description, price, category, image_url, posting_user)
     VALUES(:title, :description, :price, :category, :image_url, :posting_user)");
    $stmt ->bindValue(':title', $ad['title'], PDO::PARAM_STR);
    $stmt ->bindValue(':description', $ad['description'], PDO::PARAM_STR);
    $stmt ->bindValue(':price', $ad['price'], PDO::PARAM_STR);
    $stmt ->bindValue(':category', $category, PDO::PARAM_STR);
    $stmt ->bindValue(':image_url', $ad['image_url'], PDO::PARAM_STR);
    $stmt ->bindValue(':posting_user', $ad['posting_user'], PDO::PARAM_STR);
    $stmt->execute();
    echo "Inserted ID: " . $dbc->lastInsertId() . PHP_EOL;
    
}