<?php
class Login {
  private $pdo;
  private $user;
  private $password;

  public function __CONSTRUCT() {
    try	{
      $this->pdo = Database::Conectar();
    }
    catch(Exception $e)	{
      die($e->getMessage());
    }
  }

  public function Login($user,$password) {
    try {
      $stm = $this->pdo->prepare("SELECT ID,password FROM Q_users WHERE email = ? and active = 1");
      $stm->execute(array($user));
      $r = $stm->fetch(PDO::FETCH_OBJ);
      if ($stm->rowCount() > 0) {
        if (password_verify($password, $r->password)) {
          session_start();
          $_SESSION["id-PQB"] = $r->ID;
          session_write_close();
          return true;
          return $stm->fetch(PDO::FETCH_OBJ);
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
    catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function GetEmail($email) {
    try {
      $stm = $this->pdo->prepare("SELECT * FROM Q_users WHERE email = ?");
      $stm->execute(array($email));
      if ($stm->rowCount() > 0) {
        return true;
      }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function GetPhone($phone) {
    try {
      $stm = $this->pdo->prepare("SELECT * FROM Q_users WHERE phone = ?");
      $stm->execute(array($phone));
      if ($stm->rowCount() > 0) {
        return true;
      }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function SendEmail($email, $nombre, $asunto, $cuerpo){
      require 'assets/plugins/PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->SMTPDebug = 1;
$mail->CharSet = 'UTF-8';
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->Port = 25;
$mail->SMTPAuth = true;
    $mail->Username = 'a.sepulveda@es-metals.com';
    $mail->Password = 'Colombia2020*';
$mail->setFrom('a.sepulveda@es-metals.com','Alejandra Sepulveda');
$mail->addReplyTo('a.sepulveda@es-metals.com','Alejandra Sepulveda');
    $mail->addAddress($email, $nombre);



$mail->Subject = "ES METALS PROPOSAL";
$mail->msgHTML("
<div style='width:90%;border-radius:10px;background:white;color:black;font-size:14px;font-family:Century Gothic;padding:30px;text-align:justify'>
<div style='width:100%;border-radius:50px;padding:20px 0 20px 0;background:#FFF;text-align:center'><img style='max-width:80%' src='cid:scope'></div>
<br>
Greetings!
<br><br>
In accordance with your request, ES Metals is pleased to provide you with the Proposal for the project <br>
Details, terms and conditions can be found in the files attached. 
<br><br>
Should you have any questions please don’t hesitate to contact The ES Metals team.
<br><br>
<br>
<div style='font-size:10px;text-align:justify'>
The information contained in this electronic mail transmission is intended by ES Metals solely for the use of the named individual or entity to which it is directed, and may contain information that is confidential, privileged or otherwise protected by law, including by applicable copyright or other laws protecting intellectual property or trade secrets. If you are not the individual or entity to whom this electronic mail transmission is directed, or otherwise have reason to believe that you received this electronic mail transmission in error, please delete it from your system without copying or forwarding it, and notify the sender by reply email, so that the intended recipient's address can be corrected.
</div>
");
$mail->AltBody = "We are pleased to provide you with the following proposal and corresponding terms and conditions.";
          if($mail->send())
    return true;
    else
  echo "There was a problem sending the form.: " . $mail->ErrorInfo;
  }

}
