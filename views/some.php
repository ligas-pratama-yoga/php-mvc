@define('title', '1000')
<form action="/method" method="post">
  <?= csrf() ?>
  <input type="number" name="id">
  <input type="text" name="nama">
  @error('nama')
  <p style="color: red">
    <?= $error ?>
  </p>
  @enderror
  <input type="number" name="umur">
  <button type="submit">Submit</button>
</form>
