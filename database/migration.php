<?PHP

define("DB_HOST", '127.0.0.1');

define("DB_NAME", 'adlister_db');

define("DB_USER", 'user');

define("DB_PASS", 'password');

require_once 'db_connect.php';

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$dropTableIf = "DROP TABLE IF EXISTS ads";

$dbc->exec($dropTableIf);

$addTable = "CREATE TABLE ads (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(30) NOT NULL,
    date_created DATE NOT NULL,
    description VARCHAR(500) NOT NULL,
    image_url VARCHAR(200),
    PRIMARY KEY (id))";

$dbc->exec($addTable);