<?php require_once 'includes/auth.php'; require_login(); require_once 'includes/db.php'; include 'includes/header.php';
$msg='';
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tenant'])){
  $full = $_POST['full_name']; $email = $_POST['email']; $phone = $_POST['phone']; $address = $_POST['address']; $age = (int)$_POST['age']; $occupation = $_POST['occupation']; $unit_id = $_POST['unit_id']?:null;
  $id_image = null;
  if(!empty($_FILES['id_image']['name'])){
    $target = 'uploads/ids/'; if(!is_dir($target)) mkdir($target,0777,true);
    $fn = time().'_'.basename($_FILES['id_image']['name']); move_uploaded_file($_FILES['id_image']['tmp_name'],$target.$fn); $id_image = $target.$fn;
  }
  $stmt = $pdo->prepare('INSERT INTO tenants (full_name,email,phone,address,age,occupation,unit_id,id_image) VALUES (?,?,?,?,?,?,?,?)');
  $stmt->execute([$full,$email,$phone,$address,$age,$occupation,$unit_id,$id_image]);
  if($unit_id){ $pdo->prepare('UPDATE units SET status="occupied", tenant_id=? WHERE id=?')->execute([$pdo->lastInsertId(), $unit_id]); }
  $msg='Tenant added';
}
$units = $pdo->query('SELECT id,unit_number FROM units WHERE status="vacant" OR status IS NULL')->fetchAll();
tenants = $pdo->query('SELECT t.*, u.unit_number FROM tenants t LEFT JOIN units u ON t.unit_id = u.id ORDER BY t.id DESC')->fetchAll();
?>
<div class="d-flex">
  <aside class="sidebar"><h3>APARTMENT</h3></aside>
  <main class="main">
    <h2>Tenants Information</h2>
    <?php if($msg) echo '<div class="alert alert-success">'.htmlspecialchars($msg).'</div>'; ?>
    <div class="form-box mb-3"><form method="post" enctype="multipart/form-data">
      <div class="row"><div class="col-md-6"><label>Full Name</label><input name="full_name" class="form-control" required></div>
      <div class="col-md-6"><label>Email</label><input name="email" class="form-control" required></div></div>
      <div class="row"><div class="col-md-4"><label>Phone</label><input name="phone" class="form-control"></div>
      <div class="col-md-4"><label>Age</label><input type="number" name="age" class="form-control"></div>
      <div class="col-md-4"><label>Occupation</label><input name="occupation" class="form-control"></div></div>
      <label>Address</label><input name="address" class="form-control">
      <label>Assign Unit</label><select name="unit_id" class="form-control"><option value="">-- None --</option><?php foreach($units as $un): ?><option value="<?= $un['id'] ?>"><?= htmlspecialchars($un['unit_number']) ?></option><?php endforeach; ?></select>
      <label>Upload ID (jpg/png)</label><input type="file" name="id_image" class="form-control">
      <button name="add_tenant" class="btn btn-primary mt-2">Add Tenant</button>
    </form></div>

    <div class="table-responsive"><table class="table"><thead><tr><th>ID</th><th>Unit</th><th>Name</th><th>Contact</th><th>Occupation</th><th>ID Copy</th></tr></thead><tbody>
    <?php foreach($tenants as $t): ?><tr><td><?= $t['id'] ?></td><td><?= $t['unit_number']?:'Unassigned' ?></td><td><?= htmlspecialchars($t['full_name']) ?></td><td><?= htmlspecialchars($t['phone']) ?></td><td><?= htmlspecialchars($t['occupation']) ?></td><td><?php if($t['id_image']) echo '<a href="'.htmlspecialchars($t['id_image']).'" target="_blank">View ID</a>'; else echo 'No ID'; ?></td></tr><?php endforeach; ?>
    </tbody></table></div>
  </main>
</div>
<?php include 'includes/footer.php'; ?>