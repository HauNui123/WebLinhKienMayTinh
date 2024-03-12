<?php
class Category
{
    public $id;
    public $name;

    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM category";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
            return $stmt->fetchAll();
        }
    }
}