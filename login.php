<?php
require 'config.php';
if ($_POST) {
    $u = q('SELECT * FROM users WHERE email = ?', [$_POST['email']])->fetch();
    if ($u && password_verify($_POST['password'], $u['password'])) {
        session_regenerate_id(true);
        unset($u['password']);
        $_SESSION['user'] = $u;
        go($u['role'] == 'admin' ? 'admin/index.php' : 'index.php');
    }
    $err = 'Email atau password salah';
}
require 'header.php';
?>
<div class="col-md-5 mx-auto">
  <h3>Masuk</h3>
  <?php if (isset($err)) echo "<div class='alert alert-danger'>$err</div>"; ?>
  <form method="post"><?= csrf() ?>
    <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
    <div class="input-group mb-2">
      <input class="form-control" type="password" name="password" placeholder="Password" required>
      <button type="button" class="btn btn-outline-secondary" onclick="lihat(this)"><i class="bi bi-eye"></i></button>
    </div>
    <button class="btn btn-primary">Masuk</button>
    <a href="register.php">Daftar</a>
  </form>
</div>
<?php require 'footer.php'; ?>
