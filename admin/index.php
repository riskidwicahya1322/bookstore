<?php
$r = '../'; require '../config.php'; need(true);
$n = q("SELECT (SELECT COUNT(*) FROM books) b, (SELECT COUNT(*) FROM users) u,
  (SELECT COUNT(*) FROM orders WHERE status = 'pending') p, (SELECT COUNT(*) FROM messages WHERE is_read = 0) m,
  (SELECT COALESCE(SUM(total), 0) FROM orders WHERE status = 'completed') r")->fetch();
require '../header.php';
?>
<div class="row g-3">
  <?php foreach (['p' => 'Pesanan menunggu', 'm' => 'Pesan belum dibaca', 'b' => 'Judul buku', 'u' => 'Pengguna'] as $k => $l): ?>
    <div class="col-6 col-md-3"><div class="card text-center"><div class="card-body"><h3><?= $n[$k] ?></h3><?= $l ?></div></div></div>
  <?php endforeach ?>
</div>
<p class="mt-3">Pendapatan (pesanan selesai): <b><?= rp($n['r']) ?></b></p>
<?php require '../footer.php'; ?>
