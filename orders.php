<?php
require 'config.php';
need();
$orders = q('SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC', [user()['id']])->fetchAll();
require 'header.php';
?>
<h3>Pesanan saya</h3>
<?php if (!$orders) echo '<p>Belum ada pesanan.</p>'; ?>
<?php foreach ($orders as $o): ?>
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
      <span>#<?= $o['id'] ?> &middot; <?= $o['created_at'] ?></span>
      <span class="badge bg-info"><?= e($o['status']) ?></span>
    </div>
    <ul class="list-group list-group-flush">
      <?php foreach (q('SELECT * FROM order_items WHERE order_id = ?', [$o['id']]) as $i): ?>
        <li class="list-group-item d-flex justify-content-between">
          <span><?= e($i['title']) ?> &times; <?= $i['qty'] ?></span><span><?= rp($i['price'] * $i['qty']) ?></span>
        </li>
      <?php endforeach ?>
      <li class="list-group-item fw-bold">Total (bayar di tempat): <?= rp($o['total']) ?></li>
    </ul>
  </div>
<?php endforeach ?>
<?php require 'footer.php'; ?>
