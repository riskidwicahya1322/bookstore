<?php
$r = '../'; require '../config.php'; need(true);
if ($_POST) {
    q('UPDATE orders SET status = ? WHERE id = ?', [$_POST['status'], $_POST['id']]);
    go('orders.php');
}
$st = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
require '../header.php';
?>
<?php foreach (q('SELECT * FROM orders ORDER BY id DESC') as $o): ?>
  <div class="card mb-3"><div class="card-body">
    <b>#<?= $o['id'] ?></b> &middot; <?= e($o['name']) ?> &middot; <?= e($o['phone']) ?> &middot; <?= $o['created_at'] ?><br>
    <?= e($o['address']) ?>
    <ul>
      <?php foreach (q('SELECT * FROM order_items WHERE order_id = ?', [$o['id']]) as $i): ?>
        <li><?= e($i['title']) ?> &times; <?= $i['qty'] ?></li>
      <?php endforeach ?>
    </ul>
    <form method="post" class="d-flex gap-2"><?= csrf() ?>
      <input type="hidden" name="id" value="<?= $o['id'] ?>">
      <select name="status" class="form-select w-auto">
        <?php foreach ($st as $s): ?><option <?= $o['status'] == $s ? 'selected' : '' ?>><?= $s ?></option><?php endforeach ?>
      </select>
      <button class="btn btn-primary">Simpan</button>
      <span class="ms-auto fw-bold"><?= rp($o['total']) ?></span>
    </form>
  </div></div>
<?php endforeach ?>
<?php require '../footer.php'; ?>
