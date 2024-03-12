<?php

use Cart as GlobalCart;

class Cart
{
    public $id_ND;
    public $name;
    public $price;
    public $quantiy;

    public static function getAllCart($pdo,$id) {
        $sql = "SELECT * FROM cart  WHERE id_ND = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cart');
            return $stmt->fetchAll();
        }
    }

    public static function getOneCartByID($pdo, $id,$name) {
        $sql = "SELECT * FROM cart WHERE id_ND = :id AND name=:Name";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':Name', $name, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cart');
            return $stmt->fetch();
        }
    }

    public static function addCart($pdo,$data)
    {
       
        if(isset($_GET['action']) && isset($_GET['proid']) && isset($_SESSION['log_detail']))
        {       $id_ND=$_SESSION['id'];
                $action = $_GET['action'];
                $proid = $_GET['proid'];
                if ($action == 'addcart') {
                    $product = Product::getOneByID($pdo, $proid);
                    if ($product) {
                        $proidCol = Cart::getOneCartByID($pdo,$id_ND,$product->name);
                        if ($proidCol) {
                            $sql = "UPDATE `cart` SET `quantiy`= :quantity WHERE `id_ND` = :id AND `name`=:Name";
                            $stmt = $pdo->prepare($sql);
                            
                            $quantity=$proidCol->quantiy+1;
                            $stmt->bindParam(':quantity',$quantity, PDO::PARAM_INT);
                            $stmt->bindParam(':id', $id_ND, PDO::PARAM_INT);
                            $stmt->bindParam(':Name',$product->name, PDO::PARAM_STR);

                            if ($stmt->execute()) {
                                return true;
                            } else {
                                $error = $stmt->errorInfo();
                                var_dump($error);
                            }
                        } else {
                            $sql = "INSERT INTO `cart`(`id_ND`,`name`, `price`, `quantiy`) VALUES (:id,:name, :price,:quantity)";
                            $stmt = $pdo->prepare($sql);

                            $stmt->bindValue(':id', $id_ND , PDO::PARAM_INT);
                            $stmt->bindValue(':name',$product->name, PDO::PARAM_STR);
                            $stmt->bindValue(':price', $product->price, PDO::PARAM_STR);
                            $stmt->bindValue(':quantity', 1, PDO::PARAM_INT);

                            if ($stmt->execute()) {
                                return true;
                            }
                        }
                    }
                }
        } 
    }

    public static function editCart($pdo)
    {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == 'empty') {
                $sql = "DELETE FROM `cart` WHERE `id_ND` = :id";
                $stmt = $pdo->prepare($sql);
                            
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return true;
                } else {
                    $error = $stmt->errorInfo();
                    var_dump($error);
                }
            }
            if ($action =='detele') {
                $proName = $_GET['proName'];
                $sql = "DELETE FROM `cart` WHERE `id_ND` = :id AND `name` = :Name";
                $stmt = $pdo->prepare($sql);
                            
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                $stmt->bindValue(':Name',$proName, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    return true;
                } else {
                    $error = $stmt->errorInfo();
                    var_dump($error);
                }
            }
            if ($action =='update') {
                $proName = $_GET['proName'];
                $quantity = $_GET['quantiy'];

                $sql = "UPDATE `cart` SET `quantiy`= :quantity WHERE `id_ND` = :id AND `name`=:Name";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindParam(':quantity',$quantity, PDO::PARAM_INT);
                $stmt->bindParam(':id',  $_SESSION['id'], PDO::PARAM_INT);
                $stmt->bindParam(':Name',$proName, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    return true;
                } else {
                    $error = $stmt->errorInfo();
                    var_dump($error);
                }
            }
        }
    }
}
