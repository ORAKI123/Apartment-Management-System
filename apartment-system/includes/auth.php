<?php
if (session_status() === PHP_SESSION_NONE) session_start();
function require_login(){ if (empty($_SESSION['user_id'])){ header('Location: index.php'); exit; } }
function is_admin(){ return (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'); }
?>
