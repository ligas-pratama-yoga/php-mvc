@define("title", "Hello")
<form action="/method" method="post">
  <?= csrf() ?>
  <input type="number" name="id">
  <input type="text" name="nama">
  <input type="number" name="umur">
  <button type="submit">Submit</button>
</form>
