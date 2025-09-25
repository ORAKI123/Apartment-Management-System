<?php
require_once 'includes/auth.php'; require_login(); require_once 'includes/db.php'; include 'includes/header.php';
$total_units = $pdo->query('SELECT COUNT(*) FROM units')->fetchColumn() ?: 0;
$rented_units = $pdo->query("SELECT COUNT(*) FROM units WHERE status='occupied'")->fetchColumn() ?: 0;
$vacant_units = $total_units - $rented_units;
$total_tenants = $pdo->query('SELECT COUNT(*) FROM tenants')->fetchColumn() ?: 0;
$monthly_income = $pdo->query('SELECT IFNULL(SUM(amount),0) FROM payments WHERE MONTH(payment_date)=MONTH(CURDATE()) AND YEAR(payment_date)=YEAR(CURDATE())')->fetchColumn() ?: 0;
$today_dues = 0;
?>
<div class="d-flex">
  <aside class="sidebar">
    <h3>APARTMENT</h3><p class="mb-4">Management System</p>
    <a class="active" href="dashboard.php">Owner Dashboard</a>
    <a href="units.php">Units Information</a>
    <a href="tenants.php">Tenants Information</a>
    <a href="payments.php">Payment Management</a>
    <hr style="border-color: rgba(255,255,255,0.08)">
    <a href="profile.php">My Profile</a>
    <?php if(is_admin()): ?><a href="logs.php">System Logs</a><?php endif; ?>
  </aside>
  <main class="main flex-grow-1">
    <h2>Dashboard</h2>
    <div class="row gy-3">
      <div class="col-md-4"><div class="card p-3"><h4><?= $total_units ?></h4><p>Total Units</p></div></div>
      <div class="col-md-4"><div class="card p-3"><h4><?= $rented_units ?></h4><p>Rented Units</p></div></div>
      <div class="col-md-4"><div class="card p-3"><h4><?= $vacant_units ?></h4><p>Vacant Units</p></div></div>
      <div class="col-md-4"><div class="card p-3"><h4><?= $total_tenants ?></h4><p>All Tenants</p></div></div>
      <div class="col-md-4"><div class="card p-3"><h4>₱<?= number_format($monthly_income,2) ?></h4><p>Monthly Earnings</p></div></div>
      <div class="col-md-4"><div class="card p-3"><h4><?= $today_dues ?></h4><p>Today Dues</p></div></div>
    </div>
  </main>
</div>
<?php include 'includes/footer.php'; ?>