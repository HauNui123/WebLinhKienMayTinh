<?php
$title = 'New Product';
require '../class/Database.php';
require '../class/Product.php';
require 'class/Auth.php';
require '../class/Category.php';
require '../inc/init.php';

$error = '';
$error = Auth::requireLogin();


$name = '';
$desc = '';
$price = '';
$image='';
$categories='';

$nameErrors = '';
$descErrors = '';
$priceErrors = '';

$db = new Database();
$pdo = $db->getConnect();
$categories = Category::getAll($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $selected_cateID = $_POST['category'];

    if (empty($name)) {
        $nameErrors = 'Name is required';
    }

    if (empty($desc)) {
        $descErrors = 'Description is required';
    }

    if (empty($price)) {
        $priceErrors = 'Price is required';
    } elseif ($price % 1000 != 0) {
        $priceErrors = 'Price must be devisible by 1000.';
    }

    require 'upload.php';

    if (!$nameErrors && !$descErrors && !$priceErrors) {
        
        
        $product = new Product();
        $product->name = $name;
        $product->desc = $desc;
        $product->price = $price;
        $product->image_file = $image;
        $product->category_id=$selected_cateID;

        if ($product->create($pdo)) {
            header("Location: product.php?id={$product->id}");
            exit;         
        }
    }
}
?>

<?php require 'inc/header.php'; ?>

<?php if (!$error) : ?>

    <h2>Thêm sản phẩm mới</h2>
    <form method="post" class="w-50 m-auto" enctype='multipart/form-data'>
        <div class="mb-3">
            <label for="name" class="form-label">Name (*)</label>
            <input class="form-control" id="name" name="name" value="<?= $name ?>" /> <span class="text-danger fw-bold"><?= $nameErrors ?></span>
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Description (*)</label>
            <textarea class="form-control" id="desc" name="desc" rows="4"><?= $desc ?></textarea> <span class="text-danger fw-bold"><?= $descErrors ?></span>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price (*)</label>
            <input class="form-control" id="price" name="price" type="number" value="<?= $price ?>" /> <span class="text-danger fw-bold"><?= $priceErrors ?></span>
        </div>
        <div class="mb-3">
            <label for="file">Image file</label>
            <input class="form-control" id="file"type="file" name="file" />
        </div>
        <h5>Chọn Loại Sản Phẩm</h5>
        <?php foreach ($categories as $cate) : ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category<?= $cate->id ?>" value="<?= $cate->id ?>">
                <label class="form-check-label" for="category<?= $cate->id ?>">
                    <?= $cate->name ?>
                </label>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Add new</button>
    </form>

<?php else: ?>

    <h2 class="text-center text-danger"><?= $error ?></h2>

<?php endif; ?>
