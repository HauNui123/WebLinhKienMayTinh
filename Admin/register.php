<?php
$title = 'Register page';
require 'class/Auth.php';
require '../class/Database.php';
require '../inc/init.php';

$username = '';
$password = '';
$email = '';
$admin = 1;
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $db = new Database();
    $pdo = $db->getConnect();
    $error=Auth::KT_trungtenDNvaEmail($pdo,$username,$email);
    if(!$error)
    {
        $passwordhash=Auth::MaHoaMK($password);

        $DangKi = new Auth();
        $DangKi->ten_DN=$username;
        $DangKi->matkhau=$passwordhash;
        $DangKi->admin=$admin;
        $DangKi->email=$email;
    
        if ($DangKi->createAccount($pdo)) {
            header("Location:indexAdmin.php");
            exit;
        }
    }
   
}
?>

<?php require 'inc/header.php'; ?>
<?php if (!$error) : ?>
    <div class="container text-center d-flex align-items-center min-vh-100">
        <div class="card mx-auto bg-info py-5" style="width: 25rem;">
            <h1>Đăng Kí</h1>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">OK!!!</button>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <h2 class="text-center text-danger"><?= $error ?></h2>
<?php endif; ?>
