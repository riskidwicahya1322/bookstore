<?php $r = $r ?? ''; $u = user(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Toko Buku Lentera</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?= $r ?>index.php">Toko Buku Lentera</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#m"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="m">
      <div class="navbar-nav me-auto">
        <a class="nav-link" href="<?= $r ?>index.php">Beranda</a>
        <a class="nav-link" href="<?= $r ?>about.php">Tentang</a>
        <a class="nav-link" href="<?= $r ?>contact.php">Kontak</a>
      </div>
      <div class="navbar-nav">
        <a class="nav-link" href="<?= $r ?>cart.php">Keranjang (<?= array_sum($_SESSION['cart'] ?? []) ?>)</a>
        <?php if ($u): ?>
          <?php if ($u['role'] == 'admin'): ?><a class="nav-link" href="<?= $r ?>admin/index.php">Admin</a><?php endif ?>
          <a class="nav-link" href="<?= $r ?>orders.php">Pesanan</a>
          <a class="nav-link" href="<?= $r ?>logout.php">Keluar (<?= e($u['name']) ?>)</a>
        <?php else: ?>
          <a class="nav-link" href="<?= $r ?>login.php">Masuk</a>
        <?php endif ?>
      </div>
    </div>
  </div>
</nav>
<div class="container">
<?php if ($r): ?>
  <ul class="nav nav-pills mb-3">
    <?php foreach (['index' => 'Dashboard', 'books' => 'Buku', 'categories' => 'Kategori', 'orders' => 'Pesanan', 'messages' => 'Pesan', 'users' => 'Pengguna'] as $f => $l): ?>
      <li class="nav-item"><a class="nav-link <?= basename($_SERVER['SCRIPT_NAME'], '.php') == $f ? 'active' : '' ?>" href="<?= $f ?>.php"><?= $l ?></a></li>
    <?php endforeach ?>
  </ul>
<?php endif ?>
