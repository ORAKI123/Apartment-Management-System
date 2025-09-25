<?php
session_start();
require_once 'includes/db.php';
if(!empty($_SESSION['user_id'])){ header('Location: dashboard.php'); exit; }
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if($username === '' || $password === '') $error='Enter username and password.';
    else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if($user && password_verify($password, $user['password'])){
            if($user['status'] !== 'active'){ $error='Account pending approval.'; }
            else {
                $_SESSION['user_id']=$user['id']; $_SESSION['username']=$user['username']; $_SESSION['role']=$user['role'];
                $pdo->prepare('INSERT INTO activity_log (user_id, action) VALUES (?,?)')->execute([$user['id'],'Logged in']);
                header('Location: dashboard.php'); exit;
            }
        } else $error='Invalid credentials.';
    }
}
?> 
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><title>Login - Apartment</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'><link rel='stylesheet' href='assets/css/style.css'></head><body>
<div class="row g-0" style="height:100vh">
  <div class="col-md-6 auth-left d-none d-md-block">
    <div class="overlay text-white">
      <h1>APARTMENT</h1><h4>MANAGEMENT SYSTEM</h4>
    </div>
  </div>
  <div class="col-md-6 bg-light d-flex align-items-center">
    <div class="auth-card w-100">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="text-center mb-3"><img src="assets/images/user.png" style="width:80px"></div>
          <?php if($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
          <form method="post" action="index.php">
            <div class="mb-2"><label class="form-label">Username</label><input name="username" class="form-control" required></div>
            <div class="mb-2"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <button class="btn btn-primary w-100">Login</button>
          </form>
          <div class="mt-3 text-center"><a href="register.php">Register (Tenant)</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
</body></html>
