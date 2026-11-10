<?php
$r = '../'; require '../config.php'; need(true);
if ($_POST) {
    if (isset($_POST['del'])) q('DELETE FROM messages WHERE id = ?', [$_POST['del']]);
    else q('UPDATE messages SET is_read = 1 WHERE id = ?', [$_POST['read']]);
    go('messages.php');
}
require '../header.php';
?>
<?php foreach (q('SELECT * FROM messages ORDER BY id DESC') as $m): ?>
  <div class="card mb-3"><div class="card-body">
    <h6><?= e($m['subject']) ?> <?php if (!$m['is_read']) echo '<span class="badge bg-danger">Baru</span>'; ?></h6>
    <small class="text-muted"><?= e($m['name']) ?> &lt;<?= e($m['email']) ?>&gt; &middot; <?= $m['created_at'] ?></small>
    <p class="mt-2"><?= nl2br(e($m['message'])) ?></p>
    <form method="post"><?= csrf() ?>
      <button name="read" value="<?= $m['id'] ?>" class="btn btn-sm btn-outline-secondary">Tandai dibaca</button>
      <button name="del" value="<?= $m['id'] ?>" class="btn btn-sm btn-danger">Hapus</button>
    </form>
  </div></div>
<?php endforeach ?>
<?php require '../footer.php'; ?>
