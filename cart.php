<?php
require 'config.php';
$_SESSION['cart'] ??= [];
$c = &$_SESSION['cart'];

if (isset($_POST['add'])) {
    $c[(int)$_POST['add']] = ($c[(int)$_POST['add']] ?? 0) + 1;
    go($_SERVER['HTTP_REFERER'] ?? 'index.php');
}
if (isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $id => $n) {
        if ((int)$n > 0) $c[(int)$id] = (int)$n; else unset($c[(int)$id]);
    }
    go('cart.php');
}

$rows = $c ? q('SELECT * FROM books WHERE id IN (' . implode(',', array_fill(0, count($c), '?')) . ')', array_keys($c))->fetchAll() : [];
$total = 0;
foreach ($rows as $b) $total += $b['price'] * $c[$b['id']];

if ($rows && isset($_POST['address'])) {
    need();
    $db->beginTransaction();
    q('INSERT INTO orders (user_id, name, phone, address, total) VALUES (?,?,?,?,?)', [user()['id'], $_POST['name'], $_POST['phone'], $_POST['address'], $total]);
    $id = $db->lastInsertId();
    foreach ($rows as $b) q('INSERT INTO order_items (order_id, book_id, title, price, qty) VALUES (?,?,?,?,?)', [$id, $b['id'], $b['title'], $b['price'], $c[$b['id']]]);
    $db->commit();
    $c = [];
    go('orders.php');
}
require 'header.php';
?>
<h3>Keranjang</h3>
<?php if (!$rows): ?>
  <p>Keranjang kosong. <a href="index.php">Belanja dulu</a></p>
<?php else: ?>
  <form method="post"><?= csrf() ?>
    <table class="table">
      <tr><th>Buku</th><th>Harga</th><th width="110">Jumlah</th><th>Subtotal</th></tr>
      <?php foreach ($rows as $b): ?>
        <tr>
          <td><?= e($b['title']) ?></td>
          <td><?= rp($b['price']) ?></td>
          <td><input class="form-control form-control-sm" type="number" min="0" name="qty[<?= $b['id'] ?>]" value="<?= $c[$b['id']] ?>"></td>
          <td><?= rp($b['price'] * $c[$b['id']]) ?></td>
        </tr>
      <?php endforeach ?>
      <tr><th colspan="3">Total</th><th><?= rp($total) ?></th></tr>
    </table>
    <button class="btn btn-outline-secondary">Perbarui (isi 0 untuk hapus)</button>
  </form>

  <h5 class="mt-4">Data pengiriman (bayar di tempat)</h5>
  <form method="post" class="col-md-6"><?= csrf() ?>
    <input class="form-control mb-2" name="name" placeholder="Nama" value="<?= e(user()['name'] ?? '') ?>" required>
    <input class="form-control mb-2" name="phone" placeholder="No. HP" pattern="[0-9+]{8,16}" required>
    <textarea class="form-control mb-2" name="address" placeholder="Alamat lengkap" required></textarea>
    <button class="btn btn-primary"><?= user() ? 'Pesan sekarang' : 'Masuk untuk memesan' ?></button>
  </form>
<?php endif ?>
<?php require 'footer.php'; ?>
