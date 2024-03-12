<?php
$title = 'Product page';
if (! isset($_GET["id"])) {
    die("Cần cung cấp id sản phẩm !!!");
}

$id = $_GET["id"];

require 'class/Database.php';
require 'class/Product.php';

$db = new Database();
$pdo = $db->getConnect();

$product = Product::getOneByID($pdo, $id);

if (!$product) {
    die("id không hợp lệ.");
}
?>

<?php require 'inc/header.php'; ?>

<h2 style="color: white;">Thông tin sản phẩm</h2>
<table class="table table-success">
    <tr>
        <td class="table-dark" style="width: 10%">Mã SP</td>
        <td><?= $product->id ?></td>
    </tr>
    <tr>
        <td class="table-dark">Tên SP</td>
        <td><?= $product->name ?></td>
    </tr>
    <tr>
        <td class="table-dark">Mô tả</td>
        <td><?= $product->desc ?></td>
    </tr>
    <tr>
        <td class="table-dark">Giá</td>
        <td><?= number_format($product->price, 0, ',', '.') ?> VNĐ</td>
    </tr>
    <?php if($product->image_file!=NULL): ?>
        <td class="table-dark">Image</td>
        <td> <img src="Admin/hinh/<?= $product->image_file?>"style="width: 300px; height: 300px; object-fit: cover;" /></td> 
    <?php endif; ?>
</table>

<?php require 'inc/footer.php'; ?>