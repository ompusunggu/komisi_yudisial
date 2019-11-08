<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Formulir LOGIN Siswa Baru | SMK Coding</title>
</head>

<body>
<header>
  <h3>Formulir LOGIN Siswa Baru</h3>
</header>

<form action="proses-login.php" method="POST">

  <fieldset>

    <p>
      <label for="username">Email : </label>
      <input type="text" name="username" placeholder="email@mail.com"/>
    </p>

    <p>
      <label for="password">Password: </label>
      <input type="password" name="password"/>
    </p>
    <p>
      <input type="submit" value="Login" name="login"/>
    </p>

  </fieldset>

</form>

</body>
</html>

