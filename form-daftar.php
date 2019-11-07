<!DOCTYPE html>
<html>
<head>
  <title>Formulir Pendaftaran Siswa Baru | SMK Coding</title>
</head>

<body>
<header>
  <h3>Formulir Pendaftaran Siswa Baru</h3>
</header>

<form action="proses-pendaftaran.php" method="POST">

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
      <label for="confirm_password">Confirm Password: </label>
      <input type="password" name="confirm_password"/>
    </p>
    <p>
      <input type="submit" value="Daftar" name="daftar"/>
    </p>

  </fieldset>

</form>

</body>
</html>

