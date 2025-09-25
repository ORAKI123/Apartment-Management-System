<?php require_once 'includes/auth.php'; require_login(); require_once 'includes/db.php'; include 'includes/header.php';
$units = $pdo->query('SELECT u.*, t.full_name, t.email, t.phone FROM units u LEFT JOIN tenants t ON u.tenant_id = t.id ORDER BY u.id ASC')->fetchAll();
?>
<div class="d-flex">
  <aside class="sidebar"><h3>APARTMENT</h3><p>Menu</p><a href="dashboard.php">Dashboard</a><a class="active" href="units.php">Units Information</a><a href="tenants.php">Tenants</a><a href="payments.php">Payments</a></aside>
  <main class="main">
    <h2>Room Rack</h2>
    <div class="row">
      <?php foreach($units as $u): ?>
        <div class="col-6 col-md-2 mb-3">
          <div class="unit-card">
            <h5>Unit <?= htmlspecialchars($u['unit_number']) ?></h5>
            <div class="icon">
              <?php if($u['status'] === 'vacant'): ?>
                <div style="font-size:28px;color:#f0ad4e">🔑</div>
                <p class="text-muted">Vacant</p>
              <?php else: ?>
                <div style="font-size:28px;color:#198754">🏠</div>
                <p>Occupied</p>
              <?php endif; ?>
            </div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#unitModal<?= $u['id'] ?>">View</button>
          </div>
        </div>

        <div class="modal fade" id="unitModal<?= $u['id'] ?>" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header"><h5 class="modal-title">Unit <?= htmlspecialchars($u['unit_number']) ?> - Details</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
              <div class="modal-body">
                <?php if($u['status'] === 'vacant'): ?>
                  <p>This unit is currently <strong>vacant</strong>.</p>
                <?php else: ?>
                  <p><strong>Tenant:</strong> <?= htmlspecialchars($u['full_name']) ?></p>
                  <p><strong>Email:</strong> <?= htmlspecialchars($u['email']) ?></p>
                  <p><strong>Phone:</strong> <?= htmlspecialchars($u['phone']) ?></p>
                  <?php
                    $contract = $pdo->prepare('SELECT * FROM contracts WHERE unit_id = ? ORDER BY start_date DESC LIMIT 1');
                    $contract->execute([$u['id']]); $c = $contract->fetch();
                    if($c){ echo '<p><strong>Contract:</strong> '.htmlspecialchars($c['start_date']).' to '.($c['end_date']?:'Ongoing').'</p>'; }
                    $pay = $pdo->prepare('SELECT IFNULL(SUM(amount),0) as paid FROM payments WHERE contract_id IN (SELECT id FROM contracts WHERE unit_id=?)'); $pay->execute([$u['id']]); $paid = $pay->fetchColumn();
                    echo '<p><strong>Total Paid:</strong> ₱'.number_format($paid,2).'</p>';
                  ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>
</div>
<?php include 'includes/footer.php'; ?>