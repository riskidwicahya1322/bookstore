<?php
require 'config.php';
if ($_POST) {
    q('INSERT INTO messages (name, email, subject, message) VALUES (?,?,?,?)', [$_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']]);
    $ok = true;
}
require 'header.php';
?>
<div class="col-md-6 mx-auto">
  <h3>Hubungi admin</h3>
  <?php if (isset($ok)) echo '<div class="alert alert-success">Pesan terkirim.</div>'; ?>
  <form method="post"><?= csrf() ?>
    <input class="form-control mb-2" name="name" placeholder="Nama" value="<?= e(user()['name'] ?? '') ?>" required>
    <input class="form-control mb-2" type="email" name="email" placeholder="Email" value="<?= e(user()['email'] ?? '') ?>" required>
    <input class="form-control mb-2" name="subject" placeholder="Subjek" required>
    <textarea class="form-control mb-2" name="message" rows="4" placeholder="Pesan" required></textarea>
    <button class="btn btn-primary">Kirim</button>
  </form>
</div>
<?php require 'footer.php'; ?>
