<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Apartment System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Apartment System</a>
    <div>
      <?php if(!empty($_SESSION['username'])): ?>
        <span class="navbar-text text-white me-3">Hello, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a class="btn btn-sm btn-outline-light" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="btn btn-sm btn-outline-light" href="index.php">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container-fluid p-0">
