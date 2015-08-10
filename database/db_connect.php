<?php
define("DB_HOST", '127.0.0.1');

define("DB_NAME", 'adlister_db');

define("DB_USER", 'user');

define("DB_PASS", 'password');
// Get new instance of PDO object
$dbc = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);