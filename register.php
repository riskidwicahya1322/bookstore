<?php
require 'config.php';
if ($_POST) {
    if (strlen($_POST['password']) < 8) $err = 'Password minimal 8 karakter';
    else try {
        q('INSERT INTO users (name, email, password) VALUES (?,?,?)', [$_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT)]);
        go('login.php');
    } catch (PDOException $x) {
        $err = 'Email sudah terdaftar';
    }
}
require 'header.php';
?>
<div class="col-md-5 mx-auto">
  <h3>Daftar</h3>
  <?php if (isset($err)) echo "<div class='alert alert-danger'>$err</div>"; ?>
  <form method="post"><?= csrf() ?>
    <input class="form-control mb-2" name="name" placeholder="Nama" required>
    <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
    <div class="input-group mb-2">
      <input class="form-control" type="password" name="password" placeholder="Password (min. 8 karakter)" required>
      <button type="button" class="btn btn-outline-secondary" onclick="lihat(this)"><i class="bi bi-eye"></i></button>
    </div>
    <button class="btn btn-primary">Daftar</button>
    <a href="login.php">Sudah punya akun?</a>
  </form>
</div>
<?php require 'footer.php'; ?>
