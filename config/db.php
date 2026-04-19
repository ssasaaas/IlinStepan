<?php
$host = '127.0.1.27';
$db   = 'travel_agency';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    
    $pdo = new PDO($dsn, $user, $pass);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
   

} catch (PDOException $e) {
   
    echo "ОШИБКА ПОДКЛЮЧЕНИЯ: " . $e->getMessage();
    exit;
}
?>