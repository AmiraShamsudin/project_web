<?php
include '../connect.php';

session_start();

$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;

if (!$admin_id) {
    header('location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../admin/admin_header.php'; ?>

<section class="dashboard">
<h1 class="heading">Dashboard</h1>
<div class="box-container">

<div class="box">
    <?php
        $total_completes = 0;
        $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
        $select_completes->execute(['completed']);
        while ($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)) {
            $total_completes += $fetch_completes['total_price'];
        }
    ?>
    <h3><span>RM</span><?= $total_completes; ?></h3>
    <p>Total Complete</p>
    <a href="placed_order.php" class="btn">See Orders</a>
</div>

<div class="box">
    <?php
    $select_orders = $conn->prepare("SELECT * FROM `orders`");
    $select_orders->execute();
    $numbers_of_orders = $select_orders->rowCount();
    ?>
    <h3><?= $numbers_of_orders; ?></h3>
    <p>Total Orders</p>
    <a href="placed_order.php" class="btn">See Orders</a>
</div>

<div class="box">
    <?php
    $select_products = $conn->prepare("SELECT * FROM `products`");
    $select_products->execute();
    $numbers_of_products = $select_products->rowCount();
    ?>
    <h3><?= $numbers_of_products; ?></h3>
    <p>Products Added</p>
    <a href="product.php" class="btn">See Products</a>
</div>

<div class="box">
    <?php 
    $select_admins = $conn->prepare("SELECT * FROM `admin`");
    $select_admins->execute();
    $numbers_of_admins = $select_admins->rowCount();
    ?>
    <h3><?= $numbers_of_admins; ?></h3>
    <p>Admin</p>
    <a href="admin_account.php" class="btn">See Admin</a>
</div>

</section>

<?php include '../admin/admin_footer.php'; ?>
<script src="../javascipt/admin_script.js"></script>

</body>
</html>
