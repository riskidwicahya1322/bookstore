<?php
$r = '../'; require '../config.php'; need(true);
if ($_POST) {
    $f = [$_POST['title'] ?? '', $_POST['author'] ?? '', $_POST['category_id'] ?? 0, $_POST['price'] ?? 0];
    if (isset($_POST['del'])) q('DELETE FROM books WHERE id = ?', [$_POST['del']]);
    elseif ($_POST['id']) q('UPDATE books SET title=?, author=?, category_id=?, price=? WHERE id=?', [...$f, $_POST['id']]);
    else q('INSERT INTO books (title, author, category_id, price) VALUES (?,?,?,?)', $f);
    go('books.php');
}
$b = q('SELECT * FROM books WHERE id = ?', [$_GET['edit'] ?? 0])->fetch() ?: array_fill_keys(['id', 'title', 'author', 'category_id', 'price'], '');
$cats = q('SELECT * FROM categories')->fetchAll();
require '../header.php';
?>
<form method="post" class="row g-2 mb-4"><?= csrf() ?>
  <input type="hidden" name="id" value="<?= $b['id'] ?>">
  <div class="col-md-3"><input class="form-control" name="title" placeholder="Judul" value="<?= e($b['title']) ?>" required></div>
  <div class="col-md-3"><input class="form-control" name="author" placeholder="Penulis" value="<?= e($b['author']) ?>" required></div>
  <div class="col-md-2">
    <select class="form-select" name="category_id" required>
      <?php foreach ($cats as $c): ?><option value="<?= $c['id'] ?>" <?= $b['category_id'] == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach ?>
    </select>
  </div>
  <div class="col-md-2"><input class="form-control" type="number" min="1" name="price" placeholder="Harga" value="<?= e($b['price']) ?>" required></div>
  <div class="col-md-2"><button class="btn btn-primary w-100"><?= $b['id'] ? 'Simpan' : 'Tambah' ?></button></div>
</form>
<table class="table">
  <tr><th>Judul</th><th>Penulis</th><th>Kategori</th><th width="150">Harga</th><th></th></tr>
  <?php foreach (q('SELECT b.*, c.name category FROM books b JOIN categories c ON c.id = b.category_id ORDER BY b.id') as $x): ?>
    <tr>
      <td><?= e($x['title']) ?></td><td><?= e($x['author']) ?></td><td><?= e($x['category']) ?></td><td><?= rpa($x['price']) ?></td>
      <td class="text-nowrap">
        <a class="btn btn-sm btn-outline-secondary" href="?edit=<?= $x['id'] ?>">Ubah</a>
        <form method="post" class="d-inline" onsubmit="return confirm('Hapus buku ini?')"><?= csrf() ?>
          <input type="hidden" name="del" value="<?= $x['id'] ?>"><button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
  <?php endforeach ?>
</table>
<?php require '../footer.php'; ?>
