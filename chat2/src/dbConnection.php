<?php
$type = "mysql";
$host = "localhost";
$dbname = "meuChat";
$port = "8889";
$charset = "utf8mb4";

$username = "root";
$password = "root";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => pdo::FETCH_ASSOC,
    pdo::ATTR_EMULATE_PREPARES => false,
];

$dsn = "$type:host=$host;dbname=$dbname;port=$port;charset=$charset;";

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), $e->getCode());
}
