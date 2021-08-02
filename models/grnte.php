<?php
class Grnte {
private $pdo;
public $id;
public function __CONSTRUCT() {
try {
$this->pdo = Database::Conectar();
$pdo = null;
}
catch(Exception $e) {
die($e->getMessage());
}
}

public function Obtener($id) {
try {
$stm = $this->pdo->prepare("SELECT * FROM Q_users WHERE ID = ?");
$stm->execute(array($id));
return $stm->fetch(PDO::FETCH_OBJ);
}
catch (Exception $e) {
die($e->getMessage());
}
}

public function Notificacion($query) {
try {
$stm = $this->pdo->prepare("SELECT DISTINCT ID FROM Q_credits WHERE $query");
$stm->execute();
return $stm->rowCount();
}
catch(Exception $e) {
die($e->getMessage());
}
}

public function List_Approve() {
try {
$stm = $this->pdo->prepare("SELECT * FROM Q_credits where approved is null ORDER BY ID ASC");
$stm->execute(array());
return $stm->fetchAll(PDO::FETCH_OBJ);
}
catch (Exception $e) {
die($e->getMessage());
}
}

public function List_Approved() {
try {
$stm = $this->pdo->prepare("SELECT * FROM Q_credits where approved is not null ORDER BY ID ASC");
$stm->execute(array());
return $stm->fetchAll(PDO::FETCH_OBJ);
}
catch (Exception $e) {
die($e->getMessage());
}
}

public function CreditID() {
try {
$stm = $this->pdo->prepare("SELECT MAX(id) AS id FROM Q_credits");
$stm->execute();
return $stm->fetch(PDO::FETCH_OBJ);
}
catch (Exception $e) {
die($e->getMessage());
}
}

public function Save_Credit($user,$date,$city,$phone,$amount,$commission,$obs) {
try {
$sql = "INSERT INTO Q_credits (user,creation_date,request_date,city,phone,amount,commission,obs) VALUES (?,now(),?,?,?,?,?,?)";
$this->pdo->prepare($sql)->execute(array($user,$date,$city,$phone,$amount,$commission,$obs));
}
catch (Exception $e) {
die($e->getMessage());
}
}

public function Save_Approve_All($arra) {
foreach ($arra as $r) {
try {
$sql = "UPDATE Q_credits SET approved = now(),status = 1 WHERE ID = $r";
$this->pdo->prepare($sql)->execute();
}
catch (Exception $e) {
die($e->getMessage());
}
}
}

public function Save_Approve($ID,$status) {
try {
$sql = "UPDATE Q_credits SET approved = now(),status = ? WHERE ID = ?";
$this->pdo->prepare($sql)->execute(array($status,$ID));
}
catch (Exception $e) {
die($e->getMessage());
}
}

}
