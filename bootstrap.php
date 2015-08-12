<?php

require_once 'utils/Auth.php';
require_once 'utils/Input.php';
require_once 'models/Ad.php';
require_once 'database/db_connect.php';

$dbc = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);