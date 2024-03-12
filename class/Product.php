<?php
class Product
{
    public $id;
    public $name;
    public $desc;
    public $price;
    public $image_file;
    public $category_id;
    
    public static function getAll($pdo) {
        $sql = "SELECT * FROM product";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }
    public static function getdatasearch($pdo,$search)
    {
        $sql = "SELECT * FROM product WHERE name LIKE '%$search%' ORDER by id DESC";
        $stmt = $pdo->prepare($sql);    

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }
    public static function getdatatype($pdo, $type) {
        $sql = "SELECT * FROM product WHERE category_id = :id ORDER by id DESC";
        $stmt = $pdo->prepare($sql);    
        $stmt->bindValue(':id', $type, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }
    public static function getPage($pdo,$limit,$offset) {
        $sql = "SELECT * FROM product ORDER by id DESC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }


    public static function getOneByID($pdo, $id) {
        $sql = "SELECT * FROM product WHERE id = :id";
        $stmt = $pdo->prepare($sql);    
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetch();
        }
    }

    public function create($pdo) {
        $sql = "INSERT INTO `product`(`name`, `desc`, `price`, `image_file`,`category_id`) VALUES (:name, :desc, :price,:image,:cate_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':desc', $this->desc, PDO::PARAM_STR);
        $stmt->bindValue(':price', $this->price, PDO::PARAM_INT);
        $stmt->bindValue(':image', $this->image_file, PDO::PARAM_STR);
        $stmt->bindValue(':cate_id', $this->category_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
    }
    public function update($pdo)
    {
        $sql = "UPDATE `product` SET `name`= :name,`desc`=:desc,`price`=:price,`image_file`= :image,`category_id`=:cate_id WHERE `id` = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':desc', $this->desc, PDO::PARAM_STR);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
        $stmt->bindValue(':image', $this->image_file, PDO::PARAM_STR);
        $stmt->bindValue(':cate_id', $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }

    public function delete($pdo)
    {
        $sql = "DELETE FROM product WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
}