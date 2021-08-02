<head>
<title>Qu3bola - Pagos</title>
<link rel="icon" sizes="192x192" href="assets/img/ico.png" />
<link href="assets/css/login.css" rel="stylesheet" type="text/css" media="screen" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="mobile-web-app-capable" content="yes">
<meta name="robots" content="noindex">
</head>

<body>

<div class="contact">

<center>
<img src="assets/img/logo.png">
<br>
<div class="login">
<br>
<form method="post" action="?c=Login&a=Login">
<center>
<input type="text" name="user" placeholder="Email" autocomplete="off" autofocus required>
<br><br>
<input type="password" name="pass" placeholder="Contraseña" required>

<!--
<div style="vertical-align:middle;margin:15px"><input style="width:15px;zoom:1.5;vertical-align:middle" type="checkbox" name="remember" class="remember" <?php echo (isset($_COOKIE["login_usuario"])) ? 'checked' : ''; ?>>
   <label style="vertical-align:middle">Recordarme</label></div>
-->

<br><br><br>
<input type="submit" class="send" value="Login"></input>
<br>

<br><br>
    <a href="?c=Login&a=IndexRecover" style="color:#ec1c2a;text-decoration:none">¿Olvidaste tu contraseña?</a>
<br><br>
    ¿Aún no eres miembro?
    <br><a href="?c=Login&a=IndexRegister" style="color:#278dc1;text-decoration:none">¡Regístrate!</a>

</center>
</form>
</div>
</div>
</body>
