<?php
$title = 'Delete product page';
require '../class/Product.php';
require '../class/Database.php';
require '../inc/init.php';
require 'class/Auth.php';

$error = Auth::requireLogin();

$id = $_GET["id"];

$db = new Database();
$pdo = $db->getConnect();

$product = Product::getOneByID($pdo, $id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $imagedelete=$product->image_file;

    if ($product->delete($pdo, $id)) {
        $filepath = 'hinh/'.$imagedelete;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
        header('location: indexAdmin.php');
    }
}

?>

<?php
require 'inc/header.php';
?>
    <h2>Xác nhận xóa sản phẩm này</h2>
    <form action="" method="post">
        <table class="table">
            <tr>
                <th>Id</th>
                <td><?= $product->id ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?= $product->name ?></td>
            </tr>
            <tr>
                <th>Description</th>
                <td><?= $product->desc ?></td>
            </tr>
            <tr>
                <th>Price</th>
                <td><?= number_format($product->price, 0, ',', '.') ?> VNĐ</td>
            </tr>
            
        </table>
        <img src="hinh/<?= $product->image_file?>"style="width: 50%; height: 500px; object-fit: cover;" />
        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')" style="margin-top: 30px; background-color:red">Delete</button>
        <a href="product.php?id=<?= $product->id ?>" class="btn btn-danger" style="margin-top: 30px; background-color:black">Cancel</a>
    </form>
