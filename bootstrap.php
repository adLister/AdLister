<?php

$_ENV = include '.env.php';

require_once 'utils/Auth.php';
require_once 'utils/Input.php';
require_once 'models/Ad.php';

$dbc = new PDO('mysql:host='. $_ENV['DB_HOST'].';dbname='. $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);