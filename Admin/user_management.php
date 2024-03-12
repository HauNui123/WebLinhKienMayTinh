<?php
$title = 'User Management';
require '../class/Database.php';
require 'class/Auth.php';
require '../inc/init.php';

$db = new Database();
$pdo = $db->getConnect();

if(isset($_GET['id'])){
    $id_delete = $_GET['id'];
    $data = Auth::deleteUser($pdo,$id_delete);
}
$data = Auth::getAll($pdo);


?>
<?php require 'inc/header.php'; ?>
<h1>Danh Sách User</h1>
<table class="table table-success" style="text-align: center;">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Mật Khẩu</th>
            <th>Quyền</th>
            <th>Email</th>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody >
        <?php foreach ($data as $product): ?>
            <tr>
                <?php foreach (get_object_vars($product) as $key => $value): ?>
                    <?php if ($key == 'admin'): ?>
                        <?php if ($value == 1): ?>  
                            <td>Admin</td>
                        <?php else: ?>
                            <td>User</td>
                        <?php endif; ?>
                    <?php else: ?>
                        <td><?= $value?></td>
                    <?php endif; ?>
                    
                <?php endforeach; ?>
                <td>
                    <a href="user_management.php?id=<?= $product->id_DN?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>  
    </tbody>
</table>