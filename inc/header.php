<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="logo2.ico">
    <title><?= $title ?? 'No title' ?></title>

    <style>
        body {
            position: relative;
            min-height: 100vh;
            padding-top: 100px;
            padding-bottom: 200px;
        }

        footer {
            color: #fff;
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 20px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        ul li a {
            color: white;
            text-decoration: none;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        
        }
        body{
            background-image: url("Admin/hinh/background.jpg");
        }
        
    </style>
</head>



<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid" style="height: 90px; max-width: 1200px">
            <a class="navbar-brand" href="index.php"><img src="Admin/hinh/logo.png" style="width: 100px;" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a style="color:#fff; font-size: 22px;" class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>
                    </li>

                    <?php if (!isset($_SESSION['log_detail'])) :  ?>
                        <li class="nav-item">
                            <a style="color:#fff; font-size: 22px;" class="nav-link" href="register.php">Đăng ký</a>
                        </li>
                        <li class="nav-item">
                            <a style="color:#fff; font-size: 22px;" class="nav-link" href="login.php">Đăng nhập</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a  style="color:#fff; font-size: 22px;"class="nav-link" href="logout.php">Đăng xuất</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="ms-auto d-flex align-items-center">
                    <form class="d-flex justify-content-between" action="index.php" method="post">
                        <input class="form-control me-2 flex-grow-1 border-2 border-dark rounded-pill" type="search" id="search" name="search" placeholder="Search" aria-label="Search" style="width: 250px; height: 40px; border-radius: 20px;">
                        <button class="btn btn-link" type="submit"><i class="fas fa-search" style="color: #ffffff;"></i></button>
                    </form>
                    <a class="btn btn-link position-relative" href="cart.php">
                        <i class="fas fa-shopping-cart" style="color: #ffffff;"></i>          
                    </a>
                </div>
            </div>
        </div>
    </nav>
