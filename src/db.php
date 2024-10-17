<?php
// src/db.php

function getDBConnection() {
    $config = require '../config/config.php';
    $host = $config['db_host'];
    $db = $config['db_name'];
    $user = $config['db_user'];
    $pass = $config['db_pass'];

    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

