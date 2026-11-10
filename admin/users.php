<?php
$r = '../'; require '../config.php'; need(true);
require '../header.php';
?>
<table class="table">
  <tr><th>Nama</th><th>Email</th><th>Peran</th><th>Pesanan</th></tr>
  <?php foreach (q('SELECT u.*, (SELECT COUNT(*) FROM orders WHERE user_id = u.id) n FROM users u ORDER BY id DESC') as $x): ?>
    <tr><td><?= e($x['name']) ?></td><td><?= e($x['email']) ?></td><td><?= $x['role'] ?></td><td><?= $x['n'] ?></td></tr>
  <?php endforeach ?>
</table>
<?php require '../footer.php'; ?>
