</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function lihat(b) {
  let p = b.previousElementSibling;
  p.type = p.type == 'password' ? 'text' : 'password';
  b.firstElementChild.classList.toggle('bi-eye-slash');
}
</script>
</body>
</html>
