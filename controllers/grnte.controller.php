<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
require_once 'models/grnte.php';

class GrnteController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Grnte();
  }

  public function Index(){
    ini_set("session.cookie_lifetime","28800");
    ini_set("session.gc_maxlifetime","28800");
    session_start();
    $id = $_SESSION["id-PQB"];
    $alm = $this->model->Obtener($id);
    require_once 'views/header.php';
    require_once 'views/page.php';
    require_once 'views/footer.php';
  }

  public function Credit(){
    ini_set("session.cookie_lifetime","28800");
    ini_set("session.gc_maxlifetime","28800");
    session_start();
    $id = $_SESSION["id-PQB"];
    $alm = $this->model->Obtener($id);
    require_once 'views/header.php';
    require_once 'views/credit.php';
    require_once 'views/footer.php';
  }

  public function Approve(){
    ini_set("session.cookie_lifetime","28800");
    ini_set("session.gc_maxlifetime","28800");
    session_start();
    $id = $_SESSION["id-PQB"];
    $alm = $this->model->Obtener($id);
    require_once 'views/header.php';
    require_once 'views/approve.php';
    require_once 'views/footer.php';
  }

  public function Report(){
    ini_set("session.cookie_lifetime","28800");
    ini_set("session.gc_maxlifetime","28800");
    session_start();
    $id = $_SESSION["id-PQB"];
    $alm = $this->model->Obtener($id);
    require_once 'views/header.php';
    require_once 'views/report.php';
    require_once 'views/footer.php';
  }

   public function Save_Credit(){
     session_start();
     $user = $_SESSION["id-PQB"];
     $city=$_REQUEST['city'];
     $phone=$_REQUEST['phone'];
     $date=$_REQUEST['date'];
     $amount=$_REQUEST['amount'];
     $commission=$_REQUEST['commission'];
     $obs=$_REQUEST['obs'];
     $this->model->Save_Credit($user,$date,$city,$phone,$amount,$commission,$obs);
     $credit=$this->model->CreditID()->id;
     $carpeta = "files/$credit";
     if (!file_exists($carpeta)) {
       mkdir($carpeta, 0777, true);
     }
     $total = count($_FILES['upload']['name']);
     for($i=0; $i<$total; $i++) {
       $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
       if ($tmpFilePath != ""){
         $newFilePath = "files/$credit/" . $_FILES['upload']['name'][$i];
         if(move_uploaded_file($tmpFilePath, $newFilePath)) {}
         }
       }
       echo "<script type='text/javascript'>
       window.history.go(-1);
       </script>";
  }

  public function Save_Approve_All(){
  $arra = $_REQUEST['arra'];
  $arra = explode(",", substr($arra,1));
  $this->model->Save_Approve_All($arra);
  echo "<script type='text/javascript'>
  window.location='?c=Grnte&a=Approve'
  </script>";
  }

  public function Save_Approve(){
$ID = $_REQUEST['id'];
$status = $_REQUEST['status'];
$this->model->Save_Approve($ID,$status);
echo "<script type='text/javascript'>
window.location='?c=Grnte&a=Approve'
</script>";
}

}
