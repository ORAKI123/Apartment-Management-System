<?php
require_once 'includes/db.php';
// CHANGE these before running if you prefer a different admin password
$username = 'admin';
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
try {
    $stmt = $pdo->prepare('INSERT INTO users (username,password,role,status) VALUES (?,?,"admin","active")');
    $stmt->execute([$username,$hash]);
    echo "Admin created. Username: $username Password: $password<br>Delete this file after use.";
} catch(Exception $e){
    echo 'Error: '.$e->getMessage();
}
