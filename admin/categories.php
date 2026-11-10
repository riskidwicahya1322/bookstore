<?php
$r = '../'; require '../config.php'; need(true);
if ($_POST) {
    try {
        if (isset($_POST['del'])) q('DELETE FROM categories WHERE id = ?', [$_POST['del']]);
        elseif ($_POST['id']) q('UPDATE categories SET name = ? WHERE id = ?', [$_POST['name'], $_POST['id']]);
        else q('INSERT INTO categories (name) VALUES (?)', [$_POST['name']]);
        go('categories.php');
    } catch (PDOException $x) {
        $err = 'Gagal: nama sudah ada, atau kategori masih dipakai buku';
    }
}
$c = q('SELECT * FROM categories WHERE id = ?', [$_GET['edit'] ?? 0])->fetch() ?: ['id' => '', 'name' => ''];
require '../header.php';
?>
<?php if (isset($err)) echo "<div class='alert alert-danger'>$err</div>"; ?>
<form method="post" class="row g-2 mb-4"><?= csrf() ?>
  <input type="hidden" name="id" value="<?= $c['id'] ?>">
  <div class="col-md-6"><input class="form-control" name="name" placeholder="Nama kategori" value="<?= e($c['name']) ?>" required></div>
  <div class="col-md-2"><button class="btn btn-primary w-100"><?= $c['id'] ? 'Simpan' : 'Tambah' ?></button></div>
</form>
<table class="table">
  <tr><th>Kategori</th><th>Jumlah buku</th><th></th></tr>
  <?php foreach (q('SELECT c.*, (SELECT COUNT(*) FROM books WHERE category_id = c.id) n FROM categories c ORDER BY id') as $x): ?>
    <tr>
      <td><?= e($x['name']) ?></td><td><?= $x['n'] ?></td>
      <td class="text-nowrap">
        <a class="btn btn-sm btn-outline-secondary" href="?edit=<?= $x['id'] ?>">Ubah</a>
        <form method="post" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')"><?= csrf() ?>
          <input type="hidden" name="del" value="<?= $x['id'] ?>"><button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
  <?php endforeach ?>
</table>
<?php require '../footer.php'; ?>
