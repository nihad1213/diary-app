<?php

/* Connect Database */

try 
{
    $pdo = new PDO('mysql:host=localhost;dbname=diary-app-php;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} 
catch (PDOException $e) 
{
    echo 'Error: ' . $e->getMessage();
    die();
}
