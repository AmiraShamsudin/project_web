<?php
include '../connect.php';
session_start();

if(isset($_POST['submit'])){
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $pass = filter_var(sha1($_POST['pass']), FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT id FROM admin WHERE name = ? AND password = ?");
    $select_admin->execute([$name, $pass]);

    if($select_admin->rowCount() > 0){
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location: dashboard.php');
        exit();
    } else {
        $message = 'Incorrect username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Page</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<section class="form-container">
   <form action="" method="POST">
      <h3>Login</h3>
      <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Login Now" name="submit" class="btn">
      <p><a href="register_admin.php">Register here if you have not.</a></p>
      <?php if(isset($message)): ?>
         <p class="error"><?= $message ?></p>
      <?php endif; ?>
   </form>
</section>

</body>
</html>
