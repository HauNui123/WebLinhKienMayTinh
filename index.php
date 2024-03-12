<?php
$title = 'Home page';
require 'class/Database.php';
require 'class/Product.php';
require 'inc/init.php';
require 'class/Cart.php';


$db = new Database();
//Phân trang
$pdo = $db->getConnect();

$tong = ceil(count(Product::getAll($pdo)));
$product_per_page=8;
$tongtrang= $tong/$product_per_page;
$page=$_GET['page'] ?? 2;
if($page<=0)
{
    $page=1;
}
if($page > $tongtrang)
{
    $page=$tongtrang;
}
$limit=$product_per_page;
$offset=($page-1)*$product_per_page;
//search,type nếu ko có thì lấy toàn bộ sản phẩm ngược lại thì lấy theo tên sản phẩm tìm kiếm,type
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];
    $data = Product::getdatasearch($pdo,$search);
}
else if(isset($_GET['type'])){
    $type = $_GET['type'];
    $data = Product::getdatatype($pdo,$type);
}
else{
    $data = Product::getPage($pdo,$limit,$offset);
}

//Cart
if (isset($_GET['action']) && isset($_GET['proid']))
    {
        if (!isset($_SESSION['log_detail']))
        {
            header('location:login.php');
        }
        else
        {
            Cart::addCart($pdo,$data);
        }
    }
?>

<?php require 'inc/header.php'; ?>
<div id="demo" class="carousel slide" data-bs-ride="carousel" style="margin-left: 250px; margin-right: 250px;">

    <!-- Indicators/dots -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="4"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="5"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="6"></button>
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="Admin/hinh/carousel1.jpg"  class="d-block w-100" style="height: 350px; width: auto;">
        </div>
        <div class="carousel-item">
            <img src="Admin/hinh/carousel2.jpg"  class="d-block w-100" style="height: 350px; width: auto;">
        </div>
        <div class="carousel-item">
            <img src="Admin/hinh/carousel3.jpg"  class="d-block w-100" style="height: 350px; width: auto;">
        </div>
        <div class="carousel-item">
            <img src="Admin/hinh/carousel4.jpg"  class="d-block w-100" style="height: 350px; width: auto;">
        </div>
        <div class="carousel-item">
            <img src="Admin/hinh/carousel5.jpg"  class="d-block w-100" style="height: 350px; width: auto;">
        </div>
        <div class="carousel-item">
            <img src="Admin/hinh/carousel6.jpg"  class="d-block w-100" style="height: 350px; width: auto;">
        </div>
    </div>
        <!-- Left and right controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
<div class="container-fluid" style="padding-bottom: 30px;padding-top: 30px">
    <?php if ($data) : ?>
        <h2 style="color:white">SẢN PHẨM TIÊU BIỂU</h2>
        <div class="row">
            <div class="col-9">
                <div id="content" class="row row-cols-1 row-cols-md-4 g-4 w-100">
                <?php foreach ($data as $value) : ?>
                            <div class="col">
                                <div class="card" style="height: 450px">
                                    <img src="Admin/hinh/<?= $value->image_file ?>" class=" card-img-top " style="width: 100%; height: 300px; object-fit: cover;" />
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="product.php?id=<?= $value->id ?>"><?= $value->name ?></a></h5>
                                        <p class="card-text">Giá: <?= number_format($value->price, 0, ',', '.') ?> VNĐ</p>
                                        <a href="index.php?action=addcart&proid=<?= $value->id ?>" class="btn btn-dark" style="max-width: 100px;">Chọn mua</a>
                                    </div>
                                </div>
                            </div>      
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-3 text-white" style="height: 930px; float: left; background-color:lightslategray ;">
                <ul style="list-style-type: none; font-size: 22px;">
                    <li style="text-align: center; font-size: 25px; color: aqua;">MẶT HÀNG THEO LOẠI</li>
                    <li><a href="index.php?type=6" class="list-group-item p-2">Main Máy Tính</a></li>
                    <li><a href="index.php?type=1" class="list-group-item p-2">Chip Máy Tính</a></li>
                    <li><a href="index.php?type=11" class="list-group-item p-2">Ram Máy Tính</a></li>
                    <li><a href="index.php?type=8" class="list-group-item p-2">Nguồn Máy Tính</a></li>
                    <li><a href="index.php?type=10" class="list-group-item p-2">Ổ Cứng Máy Tính</a></li>
                    <li><a href="index.php?type=3" class="list-group-item p-2">Card Màn Hình </a></li>
                    <li><a href="index.php?type=2" class="list-group-item p-2">Tản Nhiệt Máy Tính</a></li>
                    <li><a href="index.php?type=4" class="list-group-item p-2">Case Máy Tính</a></li>
                    <li><a href="index.php?type=9" class="list-group-item p-2">Màn Hình Máy Tính</a></li>
                    <li><a href="index.php?type=7" class="list-group-item p-2">Bàn Phím Máy Tính</a></li>
                    <li><a href="index.php?type=12" class="list-group-item p-2">Tai Nghe Máy Tính</a></li>
                    <li><a href="index.php?type=5" class="list-group-item p-2">Chuột Máy Tính</a></li>
                </ul>
            </div>
        </div>
             <!-- ẩn_hiện thanh phân trang        -->
            <?php if ($_SERVER["REQUEST_METHOD"] != "POST" && ! isset($_GET['type'])) : ?>
                <nav aria-label="Page navigation example" style="margin-left: 675px;">
                    <ul class="pagination">
                        <?php 
                            if ($page > 1 && $tongtrang > 1){
                                echo ' <li class="page-item"><a class="page-link" href="index.php?page='.($page-1).'">Prev</a> </li>';
                            }

                            for ($i = 1; $i <= $tongtrang+1; $i++){
                                if ($i == $page){
                                    echo ' <li class="page-item"><a class="page-link" style="color:red;"><span">'.$i.'</span></a> </li>';
                                }
                                else{
                                    echo ' <li class="page-item"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a>  </li>';
                                }
                            }

                            if ($page < $tongtrang && $tongtrang > 1){
                                echo ' <li class="page-item"><a class="page-link" href="index.php?page='.($page+1).'">Next</a>  </li>';
                            }
                        ?>                  
                    </ul>
                </nav>
            <?php endif; ?>
    <?php else: ?>
        <h2 style="color:white">Không Có Sản Phẩm Này!!!!</h2>
    <?php endif; ?>
</div>
<?php require 'inc/footer.php'; ?>