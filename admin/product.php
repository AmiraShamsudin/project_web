<?php
include '../connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
    exit();
}

if(isset($_POST['add_product'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if($select_products->rowCount() > 0){
        $message[] = 'Product already exists!';
    } else {
        if($image_size > 200000000){
            $message[] = 'Image size is not compatible.';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `products`(name, price, image) VALUES(?,?,?)");
            $insert_product->execute([$name, $price, $image]);

            $message[] = 'New product added!';
        }
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/'.$fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    header('location:product.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../admin/admin_header.php'; ?>

<section class="add-products">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Add Product</h3>
        <input type="text" required placeholder="Product Name" name="name" maxlength="255" class="box">
        <input type="number" min="0" max="999999999" required placeholder="Product Price" name="price" class="box">
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
        <input type="submit" value="Add Product" name="add_product" class="btn">
    </form>
</section>

<section class="show-products">
    <div class="box-container">
    
    <?php
    $show_products = $conn->prepare("SELECT * FROM `products`");
    $show_products->execute();
    if($show_products->rowCount() > 0){
        while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
    ?>

    <div class="box">
        <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
        <div class="flex">
            <div class="price"><span>RM</span><?= $fetch_products['price']; ?></div>
        </div>
        <div class="name"><?= $fetch_products['name']; ?></div>
        <div class="flex-btn">
            <a href="add_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
            <a href="product.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
        </div>
    </div>
    
    <?php
        }
    } else {
        echo '<p class="empty">No products added yet!</p>';
    }
    ?>
    </div>
</section>

<?php include '../admin/admin_footer.php'; ?>
<script src="../javascript/admin_script.js"></script>

</body>
</html>
