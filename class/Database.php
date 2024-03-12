<?php
class Database {
    
    public function getConnect() {
        $host = 'localhost';
        $db = 'mydb';
        $user = 'mydb_admin';
        $pass = '*QKE!@bzA0)EJlU(';

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try {
            $pdo = new PDO($dsn, $user, $pass);
        
            return $pdo;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        // $host = 'sql207.epizy.com';
        // $db = 'epiz_33834548_mydb';
        // $user = 'epiz_33834548';
        // $pass = 'r00h7IYZHH';

        // $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        // try {
        //     $pdo = new PDO($dsn, $user, $pass);
        
        //     return $pdo;

        // } catch (PDOException $ex) {
        //     echo $ex->getMessage();
        // }
    }
}