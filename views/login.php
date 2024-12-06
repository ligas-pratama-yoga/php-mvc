<!DOCTYPE html>
<html> 
  <head> 
    <title>Login page</title>
  </head>
  <body> 
    <h1>Helo</h1>
    <form method="post"> 
<?= csrf() ?>
      <input type="text" name="username" >
      @error('username')
<p style="color: red" ><?= $error ?></p>
      @enderror
      <input type="password" name="password" >
      @error('password')
<p style="color: red" ><?= $error ?></p>
      @enderror
      <button type="submit">Submit</button>
    </form>
  </body>
</html>
