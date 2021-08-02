<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'models/login.php';

class LoginController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Login();
  }

  public function Index(){
    ob_start();
    session_start();
    if(isset($_SESSION["id-PQB"])){
      header('Location: ?c=Grnte&a=Index');
    } else {
      require_once 'views/login/login.php';
    }
  }

  public function IndexRegister(){
    $countryISO = file_get_contents('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR']);
    $countryISO = json_decode($countryISO, true);
    $countryISO = $countryISO['countryCode'];
    $countrydata = file_get_contents('assets/json/country.json');
    $countrydata = json_decode($countrydata, true);
    $countrydata = $countrydata[$countryISO];
    require_once 'views/login/register.php';
  }

  public function IndexRecover(){
    require_once 'views/login/recover.php';
  }

  public function IndexPassword(){
    require_once 'views/login/password.php';
  }

  public function Register(){
    $name=$_REQUEST['name'];
    $email=trim($_REQUEST['email']);
    $phone=$_REQUEST['phone_code'] . $_REQUEST['phone'];
    $pass=$_REQUEST['pass'];
    $continue = true;
    if ($this->model->GetEmail($email)) {
      $continue = false;
      echo 'email_exist';
    }
    if ($continue) {
      if ($this->model->GetPhone($phone)) {
        $continue = false;
        echo 'phone_exist';
      }
    }

    if ($continue) {
      $pass = password_hash($pass, PASSWORD_DEFAULT);
			$token = md5(uniqid(mt_rand(), false));
      $url = 'http://'.$_SERVER["SERVER_NAME"].'/login/activar.php?id=1&val='.$token;
			$asunto = 'Activar Cuenta - Sistema de Usuarios';
			$cuerpo = "Estimado $name: <br /><br />Para continuar con el proceso de registro, es indispensable de click en la siguiente liga <a href='$url'>Activar Cuenta</a>";
			if($this->model->SendEmail($email, $name, $asunto, $cuerpo)){
				echo "Para terminar el proceso de registro siga las instrucciones que le hemos enviado la direccion de correo electronico: $email , es posible que el correo sea marcado como spam por su proveedor de correo, esperamos que no!";
				echo "<br><a href='index.php' >Iniciar Sesion</a>";
				exit;
      } else {
				echo "Error al enviar Email";
			}
    }
  }

  public function Login(){
    $alm = new Login();
    if (isset($_REQUEST['pass']) and $_REQUEST['pass'] <> '') {
      $password=strip_tags($_REQUEST['pass']);
      $user=strip_tags($_REQUEST['user']);
      if ($this->model->Login($user,$password)) {
        header('Location: ?c=Grnte&a=Index');
      } else {
        echo '<script type="text/javascript"> alert("Usuario o Contraseña Incorrecta");window.location="?c=Login&a=Index"</script>';
      }
    } else {
      echo '<script type="text/javascript"> alert("Ingrese una contraseña");window.location="?c=Login&a=Index"</script>';
    }
  }

  public function Logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: ?c=Login&a=Index');
  }

}
