<?php

include '../connect.php';

session_start();

$message = []; 

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM admin WHERE name = ?");
   $select_admin->execute([$name]);
   
   if($select_admin->rowCount() > 0){
      $message[] = 'Username Already Exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm Password Not Matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO admin(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);

         // Fetch the new admin ID to set the session
         $select_new_admin = $conn->prepare("SELECT id FROM admin WHERE name = ?");
         $select_new_admin->execute([$name]);
         $fetch_admin_id = $select_new_admin->fetch(PDO::FETCH_ASSOC);
         $_SESSION['admin_id'] = $fetch_admin_id['id'];

         // Redirect to dashboard.php
         header('Location: dashboard.php');
         exit();
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

<section class="form-container">
   <form action="" method="POST">
      <h3>Register New</h3>
      <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" maxlength="20" required placeholder="confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" name="submit" class="btn">
      <p><a href="admin_login.php">Have Account? Log in Here.</a></p>
      <?php
         if(isset($message)){
            foreach($message as $msg){
               echo '<p class="error">'.$msg.'</p>';
            }
         }
      ?>
   </form>
</section>

<?php include '../admin/admin_footer.php'; ?>
<script src="../javascript/admin_script.js"></script>

</body>
</html>
