<?php
class Database {
    public static function Conectar() {
        $timezone = "America/Bogota";;
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=artes;charset=utf8', 'artes', '91fCq8aZ3GqUc7');
        $pdo->exec("SET time_zone = '{$timezone}'");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
