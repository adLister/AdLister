<?php
switch ($_SERVER['REQUEST_URI']) {
    case '/home':
        include 'home.php';
        break;
    case '/category=$category':
        include 'categories.php';
        break;
    case '/ads/create':
        include 'ads.create.php';
        break;
    case '/ads/edit':
        include 'ads.edit.php';
        break;
    case '/myaccount':
        include 'myaccount.php';
        break;
    default:
        include 'welcome.php';
        break;
}