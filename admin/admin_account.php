<?php
include '../connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('Location: admin_login.php');
    exit();
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
    $delete_admin->execute([$delete_id]);
    header('Location: admin_account.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Account</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>
<?php include '../admin/admin_header.php'; ?>

<section class="accounts">
    <h1 class="heading">Admin Account</h1>
    <div class="box-container">

    <?php
        $select_account = $conn->prepare("SELECT * FROM `admin`");
        $select_account->execute();
        if($select_account->rowCount() > 0){  
            while ($fetch_account = $select_account->fetch(PDO::FETCH_ASSOC)){
    ?>

    <div class="box">
        <p>Admin ID: <span><?= $fetch_account['id']; ?></span></p>
        <p>Username: <span><?= $fetch_account['name']; ?></span></p>
        <div class="flex-btn">
            <a href="admin_account.php?delete=<?= $fetch_account['id']; ?>" class="delete-btn" onclick="return confirm('Delete This Account?');">Delete</a>
            <?php 
                if($fetch_account['id'] == $admin_id){
                    echo '<a href="update_profile.php" class="option-btn">Update</a>';
                }
            ?>
        </div>
    </div>

    <?php
            }
        } else {
            echo '<p class="empty">No Account Available.</p>';
        }
    ?>
    </div>
</section>

<?php include '../admin/admin_footer.php'; ?>
<script src="../javascript/admin_script.js"></script>

</body>
</html>
