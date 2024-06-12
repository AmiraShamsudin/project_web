<?php
include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};

include 'add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Menu</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>   
<body>
    <?php
        include 'header.php';
    ?>

<div class="heading">
    <h3>Our Menu</h3>
</div>

<section class="products">

<h1 class="title">Food</h1>

<div class="box-container">

    <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
    <form action="" method="post" class="box">

    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
    <a href="quickview.php?pid=<?= $fetch_products['id']; ?>"< class="fas fa-eye"> </a>
    <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
    <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
    <div class="name"><?= $fetch_products['name']; ?></div>
    <div class="flex">
        <div class="price"><span>RM</span><?= $fetch_products['price']; ?></div>
        <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
    </div>
    </form>

    <?php
        }
    }else{
        echo '<p class="empty">NO product added yet!</p>';
        }
    ?>
</div>

</section>

<?php
include 'footer.php';
?>