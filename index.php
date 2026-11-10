<?php
require 'config.php';
$s = $_GET['s'] ?? '';
$cat = $_GET['cat'] ?? '';
$sort = in_array($_GET['sort'] ?? '', ['price', 'title']) ? $_GET['sort'] : 'id';
$cats = q('SELECT * FROM categories')->fetchAll();
$books = q("SELECT b.*, c.name category FROM books b JOIN categories c ON c.id = b.category_id WHERE (b.title LIKE ? OR b.author LIKE ?) AND (b.category_id = ? OR ? = '') ORDER BY b.$sort", ["%$s%", "%$s%", $cat, $cat])->fetchAll();
require 'header.php';
?>
<form class="row g-2 mb-4">
  <div class="col-md-5"><input class="form-control" name="s" value="<?= e($s) ?>" placeholder="Cari judul atau penulis"></div>
  <div class="col-md-3">
    <select class="form-select" name="cat">
      <option value="">Semua kategori</option>
      <?php foreach ($cats as $c): ?><option value="<?= $c['id'] ?>" <?= $cat == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach ?>
    </select>
  </div>
  <div class="col-md-2">
    <select class="form-select" name="sort">
      <option value="">Urutkan</option>
      <option value="price">Harga</option>
      <option value="title">Judul</option>
    </select>
  </div>
  <div class="col-md-2"><button class="btn btn-dark w-100">Cari</button></div>
</form>

<?php if (!$books) echo '<p>Buku tidak ditemukan.</p>'; ?>
<div class="row row-cols-1 row-cols-md-3 g-3">
  <?php foreach ($books as $b): ?>
    <div class="col">
      <div class="card h-100"><div class="card-body">
        <span class="badge bg-secondary"><?= e($b['category']) ?></span>
        <h5 class="card-title mt-2"><?= e($b['title']) ?></h5>
        <p class="text-muted"><?= e($b['author']) ?></p>
        <p class="fw-bold"><?= rp($b['price']) ?></p>
        <form method="post" action="cart.php"><?= csrf() ?>
          <input type="hidden" name="add" value="<?= $b['id'] ?>">
          <button class="btn btn-primary btn-sm">Tambah ke keranjang</button>
        </form>
      </div></div>
    </div>
  <?php endforeach ?>
</div>
<?php require 'footer.php'; ?>
