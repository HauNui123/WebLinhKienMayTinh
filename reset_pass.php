<?php
$title = 'Reset Page';
require 'class/Auth.php';
require 'class/Database.php';
require 'inc/init.php';

$db = new Database();
$pdo = $db->getConnect();

$pass1 = '';
$pass2 = '';
$pass1Errors = '';
$pass2Errors = '';

if(isset($_GET['userid'])){
    $userid = $_GET['userid'];
    $token=$_GET['token'];
    $data = Auth::getOneUserByID($pdo,$userid);
    if($data->token==NULL)
    {
        die('Link Đã Hết Hạn!!!!!');
    }
    $datetimeString = $data->datetime_reset; // Chuỗi ngày giờ cần ép kiểu
    $format = 'Y-m-d H:i:s'; // Định dạng của chuỗi ngày giờ
    $datetime = DateTime::createFromFormat($format, $datetimeString);
    $datetimenow=new DateTime();
    $interval = $datetime->diff($datetimenow);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    if (empty($pass1)) {
        $pass1Errors = 'Password is required';
    }

    if (empty($pass2)) {
        $pass2Errors = 'Password is required';
    }
    if ($pass2!=$pass1) {
        $pass2Errors = 'the password is not the same';
    }
    if (!$pass1Errors && !$pass2Errors) {

        $passwordhash=Auth::MaHoaMK($pass2);
        Auth::update_password($pdo,$userid,$passwordhash);
        Auth::reset_token_datetimereset($pdo,$userid);  
        header("Location:login.php");
        exit;      
    }  
}
?>
 <?php if ($data->token==$token && $interval->s <1): ?>
    <?php require 'inc/header.php'; ?>
    <div class="container text-center d-flex align-items-center min-vh-100">
        <div class="card mx-auto bg-info py-5" style="width: 25rem;">
            <h1>Reset Password</h1>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="pass1" class="form-label">Nhập Password Mới</label>
                        <input class="form-control" type="password" id="pass1" name="pass1"/> <span class="text-danger fw-bold"><?= $pass1Errors ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="pass2" class="form-label">Nhập Lại</label>
                        <input class="form-control" type="password" id="pass2" name="pass2"/> <span class="text-danger fw-bold"><?= $pass2Errors ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary" name="ok">ok</button>
                </form>
            </div>
        </div>
    </div>

    <?php require 'inc/footer.php'; ?>
<?php else: ?>
    <?php
        Auth::reset_token_datetimereset($pdo,$userid);  
    ?>
<?php endif; ?>