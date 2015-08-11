<?PHP


require_once 'db_connect.php';

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$dropTableIf = "DROP TABLE IF EXISTS ads";

$dbc->exec($dropTableIf);

$addTable = "CREATE TABLE ads (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(30) NOT NULL,
    date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(500) NOT NULL,
    image_url VARCHAR(200),
    PRIMARY KEY (id))";


$dbc->exec($addTable);