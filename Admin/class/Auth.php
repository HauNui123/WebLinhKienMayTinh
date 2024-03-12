<?php
class Auth 
{
    public $id_DN;
    public $ten_DN;
    public $matkhau;
    public $admin;
    public $email;
    public $token;
    public $datetime_reset;


    public static function getAll($pdo) {
        $sql = "SELECT id_DN,ten_DN,matkhau,admin,email FROM account";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auth');
            return $stmt->fetchAll();
        }
    }
    public static function deleteUser($pdo,$id)
    {
        $sql = "DELETE FROM account WHERE id_DN = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

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
            if(!$abc|| password_verify($password,$abc->matkhau)==false)
            {
                return 'Login Fail';
            }
            $kt_quyen=$abc->admin;
            if($kt_quyen == 1)
            {
                $_SESSION['log_detail'] = $username;
                header('location: ../Admin/indexAdmin.php');
                exit();
            }         
            else
            {
                $_SESSION['log_detail'] = $username;
                header('location: index.php');
                exit();
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
    public static function logout() {
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