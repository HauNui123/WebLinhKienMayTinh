<?php
$title = 'Cart page';
require 'class/Product.php';
require 'class/Auth.php';
require 'class/Database.php';
require 'class/Cart.php';
require 'inc/init.php';
$db = new Database();
$pdo = $db->getConnect();
if( !isset($_SESSION['log_detail']))
{
    header('location: login.php');
    exit;
}
$data = Cart::getAllCart($pdo,$_SESSION['id']);
if( !$data)
{
    header('location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE `cart` SET `quantiy`= :quantity WHERE `id_ND` = :id AND `name`=:Name";
    $stmt = $pdo->prepare($sql);
                
    $stmt->bindParam(':quantity',$_POST['qty'], PDO::PARAM_INT);
    $stmt->bindParam(':id',  $_SESSION['id'], PDO::PARAM_INT);
    $stmt->bindParam(':Name',$_POST['name'], PDO::PARAM_STR);
    if ($stmt->execute()) {
    } else {
        $error = $stmt->errorInfo();
        var_dump($error);
    }
}

Cart::editCart($pdo);

?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <table class="table table-success">
    <a href="cart.php?action=empty" class="btn btn-danger mt-2">Thanh Toán</a>
        <thead class="table-dark">
            <tr class="text-center">
                <th>No</th>
                <th>Pro name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th></th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
        <?php  $i = 1; $total = 0;?>
            <?php foreach ($data as $product):?>
                <form method="post"> 
                    <tr>
                        <td><?= $i ?></td>  
                        <?php foreach (get_object_vars($product) as $key => $value): ?>           
                            <?php if ($key == 'name'): $NAME=$value;?>
                            <input type="hidden" name="name" value="<?=$NAME?>  " />
                                <td><a><?= $value ?></a></td>
                            <?php elseif ($key == 'price'): ?>
                                <td><?= number_format($value, 0, ',', '.') ?> VNĐ</td>
                            <?php elseif ($key == 'quantiy'): ?>
                                <td>
                                    <input type="number" value="<?= $value ?>"name="qty" min="1" style="width: 50px;" />
                                    
                                </td>
                                <td>
                                    <input type="submit" name="update" value="Update" class="btn btn-warning" /> 
                                    <a href="cart.php?action=detele&proName=<?= $NAME?>" class="btn btn-danger">Delete</a>
                                </td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>     
                </form> 
                <?php  $i++; $total += $product->price * $product->quantiy;?>
            <?php endforeach;?>
            <tr>
                <td colspan="5" class="text-center">
                    <h4>Total: <?= number_format($total, 0, ',', '.') ?> VNĐ</h4>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php require 'inc/footer.php'; ?>