<?php
$title = 'AdminPage';
require '../class/Database.php';
require '../class/Product.php';
require '../class/Cart.php';
require '../inc/init.php';

$db = new Database();
$pdo = $db->getConnect();

$tong = ceil(count(Product::getAll($pdo)));
$product_per_page=8;
$tongtrang= $tong/$product_per_page;
$page=$_GET['page'] ?? 1;
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

if(isset($_GET['type'])){
    $type = $_GET['type'];
    $data = Product::getdatatype($pdo,$type);
}
else{
    $data = Product::getPage($pdo,$limit,$offset);
}
if (isset($_GET['action']) && isset($_GET['proid']))
    {
        if (!isset($_SESSION['log_detail']))
         header('location:login.php');
    }
    
?>

<?php require 'inc/header.php'; ?>

<div class="container-fluid" style="padding-bottom: 30px;padding-top: 30px">
        <h2>Sản Phẩm</h2>
        <div class="row">
                <div id="content" class="row row-cols-1 row-cols-md-4 g-4 w-100">
                <?php foreach ($data as $value) : ?>
                            <div class="col">
                                <div class="card" style="height: 400px">
                                    <img src="hinh/<?= $value->image_file ?>" class=" card-img-top " style="width: 100%; height: 300px; object-fit: cover;" />
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="product.php?id=<?= $value->id ?>"><?= $value->name ?></a></h5>
                                        <p class="card-text">Giá: <?= number_format($value->price, 0, ',', '.') ?> VNĐ</p>
                                    </div>
                                </div>
                            </div>      
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($_SERVER["REQUEST_METHOD"] != "POST" && ! isset($_GET['type'])) : ?>
                <nav aria-label="Page navigation example" style="margin-left: 675px;">
                    <ul class="pagination">
                        <?php 
                            if ($page > 1 && $tongtrang > 1){
                                echo ' <li class="page-item"><a class="page-link" href="indexAdmin.php?page='.($page-1).'">Prev</a> </li>';
                            }

                            for ($i = 1; $i <= $tongtrang+1; $i++){
                                if ($i == $page){
                                    echo ' <li class="page-item"><a class="page-link" style="color:red;"><span">'.$i.'</span></a> </li>';
                                }
                                else{
                                    echo ' <li class="page-item"><a class="page-link" href="indexAdmin.php?page='.$i.'">'.$i.'</a>  </li>';
                                }
                            }

                            if ($page < $tongtrang && $tongtrang > 1){
                                echo ' <li class="page-item"><a class="page-link" href="indexAdmin.php?page='.($page+1).'">Next</a>  </li>';
                            }
                        ?>                  
                    </ul>
                </nav>
    <?php endif; ?>