<?php
require 'class/Auth.php';
require 'class/Database.php';
require 'inc/init.php';

$db = new Database();
$pdo = $db->getConnect();
$email='';
$error = '';
$emailErrors='';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    if (empty($email)) {
        $emailErrors = 'email is required';
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErrors = 'Email is not valid';
    }
    else{
        $error = Auth::KT_email($pdo,$email);
    }  
}
?>

<?php require 'inc/header.php'; ?>

<div class="container text-center d-flex align-items-center min-vh-100">
    <div class="card mx-auto bg-info py-5" style="width: 25rem;">
        <h1>Forget Password</h1>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Vui Lòng Nhập Email</label>
                    <input class="form-control" id="email" name="email"/> <span class="text-danger fw-bold"><?= $emailErrors ?></span>
                </div>
                <button type="submit" class="btn btn-primary" name="login">OK</button>
            </form>
        </div>
        <?php if ($error): ?>
            <div class="card-footer">
                <h2 class="text-danger"><?= $error ?></h2>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require 'inc/footer.php'; ?>