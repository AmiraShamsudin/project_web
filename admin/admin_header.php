<?php
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
} else {
    $admin_id = null;

    header("Location: admin_login.php");
    exit;
}
?>
<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin<span>Dashboard</span></a>

      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="product.php">Products</a>
         <a href="user.php">Users</a>
         <a href="admin_account.php">Admin</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">Update Profile</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">Login</a>
            <a href="register_admin.php" class="option-btn">Register</a>
         </div>
         <a href="../admin/admin_logout.php" onclick="return confirm('Logout From This Website?');" class="delete-btn">Log Out</a>
      </div>

   </section>

</header>