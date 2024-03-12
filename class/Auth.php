<?php

use Auth as GlobalAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer-master/src/Exception.php';
require 'vendor/PHPMailer-master/src/PHPMailer.php';
require 'vendor/PHPMailer-master/src/SMTP.php';
class Auth 
{
    public $id_DN;
    public $ten_DN;
    public $matkhau;
    public $admin;
    public $email;
    public $token;
    public $datetime_reset;

    public static function Send_Email($email,$id_ND,$token) {
        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function
        


        //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.elasticemail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'vanhau98.nhd@gmail.com';                     //SMTP username
            $mail->Password   = '5C7E9891E430D9493C191F8321CD8DABB058';                               //SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('vanhau98.nhd@gmail.com', 'haudeptrai');
            $mail->addAddress($email, 'xautrai');     //Add a recipient              //Name is optional
            
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here Is The Link For You To Change Your Password';
            $mail->Body    = 'http://localhost/2001207127_NguyenVanHau_DoAn/reset_pass.php?userid='.$id_ND.'&token='.$token;
            $mail->AltBody = '';

            $mail->send();
    }
    public static function KT_email ($pdo,$email) {
        $sql = "SELECT * FROM account WHERE email= :email ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) 
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auth');
            $abc= $stmt->fetch();        
            if(!$abc )
            {
                return 'Email này chưa có đăng kí';
            }
            else{
                $datetime=date('Y-m-d H:i:s');
                $token_reset=rand(10000000, 99999999);
                $SQL = "UPDATE `account`SET `token`= :token,`datetime_reset`=:datetimereset WHERE `id_DN` = :id";
                $STMT = $pdo->prepare($SQL);
                $STMT->bindValue(':id', $abc->id_DN, PDO::PARAM_INT);
                $STMT->bindValue(':token', $token_reset, PDO::PARAM_INT);
                $STMT->bindParam(':datetimereset', $datetime, PDO::PARAM_STR);
        
                if ($STMT->execute()) {

                    Auth::Send_Email($email,$abc->id_DN,$token_reset);
                    return 'Hãy kiểm tra tin nhắn trong Email của bạn';
                } 
                else 
                {
                    $error = $STMT->errorInfo();
                    var_dump($error);
                }
            }        
        } 
        else 
        {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
    public static function reset_token_datetimereset($pdo,$id)
    {
        $sql = "UPDATE `account`SET `token`= NULL,`datetime_reset`=NULL WHERE `id_DN` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
    public static function update_password($pdo,$id,$pass)
    {
        $sql = "UPDATE `account`SET `matkhau`=:pass WHERE `id_DN` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
    public static function login ($pdo,$username, $password) {
        $sql = "SELECT * FROM account WHERE ten_DN= :ten ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':ten', $username, PDO::PARAM_STR);

        if ($stmt->execute()) 
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auth');
            $abc= $stmt->fetch();        
            if(!$abc )
            {
                return 'Login Fail';
            }
            else if(password_verify($password,$abc->matkhau)==false){
                return 'Login Fail';
            }
            else{
                $kt_quyen=$abc->admin;
                if($kt_quyen == 1)
                {
                    $_SESSION['log_detail'] = $abc->id_DN;
                    $_SESSION['id'] = $abc->id_DN;
                    header('location:Admin/indexAdmin.php');
                    exit();
                }         
                else
                {
                    $_SESSION['log_detail'] = $abc->id_DN;
                    $_SESSION['id'] = $abc->id_DN;
                    header('location: index.php');
                    exit();
                }
            }        
        } 
        else 
        {
            return 'Login Fail';
        }
    }

    public function createAccount($pdo) {
        $sql = "INSERT INTO `account`(`ten_DN`, `matkhau`, `admin`,`email`) VALUES (:ten_DN, :matkhau, :admin,:email)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':ten_DN', $this->ten_DN, PDO::PARAM_STR);
        $stmt->bindValue(':matkhau', $this->matkhau , PDO::PARAM_STR);
        $stmt->bindValue(':admin', $this->admin, PDO::PARAM_INT);
        $stmt->bindValue(':email', $this->email , PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }
        else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
    public static function KT_trungtenDNvaEmail($pdo,$username,$email) {
        $sql = "SELECT * FROM account WHERE ten_DN= :ten OR email=:email";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':ten', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        if ($stmt->execute()) 
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auth');
            $abc= $stmt->fetch();        
            if($abc)
            {
                return 'already have this username or email';
            }
        }
    }
    public static function getOneUserByID($pdo, $id) {
        $sql = "SELECT * FROM account WHERE  `id_DN` = :id";
        $stmt = $pdo->prepare($sql);    
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auth');
            return $stmt->fetch();
        }
    }
    public static function logout() {
        unset($_SESSION['log_detail']);
        header('location:index.php');
        exit;
    }
    public static function logoutAdmin() {
        unset($_SESSION['log_detail']);
        header('location: ../index.php');
        exit;
    }

    public static function requireLogin() {
        if (!isset($_SESSION['log_detail'])) {
            return 'Bạn không được phép truy cập';
        }
        return '';
    }
    public static function MaHoaMK($mk) {
        $hash=password_hash($mk,PASSWORD_DEFAULT);
        return $hash;
    }
}