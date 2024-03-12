<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title><?= $title ?? 'No title' ?></title>
</head>
<style>
    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-menu a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }

    .nav-item:hover .dropdown-menu {
        display: block;
    }
</style>
<body>
    <nav class="navbar navbar-expand" style="background-color: cyan; font-size: 20px;">
        <div class="container">
            <a class="navbar-brand" href="indexAdmin.php">Admin</a>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Loại sản phẩm
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="indexAdmin.php?type=6">Main Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=1">Chip Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=11">Ram Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=8">Nguồn Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=10">Ổ Cứng Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=3">Cart Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=2">Tản Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=4">Case Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=9">Màn Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=7">Bàn Phím Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=12">Tai Nghe Máy Tính</a>
                            <a class="dropdown-item" href="indexAdmin.php?type=5">Chuột Máy Tính</a>
                            <!-- Thêm các mục loại sản phẩm khác vào đây -->
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="new-product.php">Thêm SP mới</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_management.php">Quản Trị USER</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Đăng Kí</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>