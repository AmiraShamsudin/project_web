<?php include '../connect.php'; 

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];

    $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_user->execute([$delete_id]);

    $delete_order = $conn->prepare ("DELETE FROM `orders' WHERE user_id =?");
    $delete_order->execute([$delete_id]);

    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id =?");
    $delete_cart->execute([$delete_id]);
    
    header('location"user.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>
<?php include '../admin/admin_header.php' ?>

<section class="accounts">
   <h1 class="heading">Users</h1>
   
   <div class="box-container">
   <?php
      $select_account = $conn->prepare("SELECT * FROM `users`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>

   <div class="box">
      <p> User id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Username : <span><?= $fetch_accounts['name']; ?></span> </p>
      <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">Delete</a>
   </div>

   <?php
      }
   }else{
      echo '<p class="empty">Sorry, No Accounts Available.</p>';
   }
   ?>
   </div>
</section>  

<?php include '../admin/admin_footer.php'; ?>
<script src="../javascript/admin_script.js"></script>

</body>
</html>