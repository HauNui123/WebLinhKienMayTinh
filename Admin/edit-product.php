<?php
$title = 'Edit product page';
require '../class/Product.php';
require '../class/Database.php';
require '../inc/init.php';
require 'class/Auth.php';
require '../class/Category.php';

$id = $_GET["id"];

$db = new Database();
$pdo = $db->getConnect();

$product = Product::getOneByID($pdo, $id);
$categories = Category::getAll($pdo);

$nameErrors = '';
$priceErrors = '';
$descError = '';

$name = $product->name;
$desc = $product->desc;
$price = $product->price;
$imagedelete=$product->image_file;
$defaultCategoryId=$product->category_id;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $selected_cateID = $_POST['category'];

    // $data = $_SESSION['data'];

    if (empty($_POST['name'])) {
        $nameErrors = 'Name is required';
    }

    if (empty($_POST['desc'])) {
        $descError = 'Description is required';
    }

    if (empty($_POST['price'])) {
        $priceErrors = 'Price is required';
    } elseif ($price % 1000 != 0) {
        $priceErrors = 'Giá phải chia hết cho 1000';
    }
    require 'upload.php';

    
    

    // No errors???????
    if (!$nameErrors && !$priceErrors && !$descError) {
        $product->id = $id;
        $product->name = $name;
        $product->desc = $desc;
        $product->price = $price;
        $product->image_file = $image;
        $product->category_id=$selected_cateID;

        if ($product->update($pdo)) {
            $filepath = 'hinh/'.$imagedelete;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            header("Location: product.php?id={$product->id}");
            exit;
        }
    }
}
?>

<?php
require 'inc/header.php';
?>
    <h2>Chỉnh sửa sản phẩm</h2>
    <form action="" method="post" class="w-50 m-auto " enctype='multipart/form-data'>
        <div class="mb-3">
            <label for="name">Name: (*)</label>
            <input class="form-control" id="name" name="name" value="<?= $name ?>"> <span class='text-danger fw-bold'><?= $nameErrors ?></span>
        </div>
        <div class="mb-3">
            <label for="desc">Description: (*)</label>
            <textarea class="form-control" id="desc" name="desc" rows="4"><?= $desc ?></textarea> <span class='text-danger fw-bold'><?= $descError ?></span>
        </div>
        <div class="mb-3">
            <label for="price">Price: (*)</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= $price ?>"> <span class='text-danger fw-bold'><?= $priceErrors ?></span>
        </div>
        <div class="mb-3">
                <img src="hinh/<?= $product->image_file?>"style="width: 100%; height: 400px; object-fit: cover;" />
                <label for="file">Chọn Ảnh Khác</label>
            <input class="form-control" id="file"type="file" name="file" />
        </div>
        <h5>Chọn Loại Sản Phẩm</h5>
        <?php foreach ($categories as $cate) : ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category<?= $cate->id ?>" value="<?= $cate->id ?>" <?php if ($cate->id == $defaultCategoryId) echo "checked"; ?>>
                <label class="form-check-label" for="category<?= $cate->id ?>">
                    <?= $cate->name ?>
                </label>
            </div>
        <?php endforeach; ?>
        <button type="submit" name="submit" value="Submit" class="btn btn-primary">ok!!!</button>
        
    </form>