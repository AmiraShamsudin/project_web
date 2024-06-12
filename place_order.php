<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $status = 'Pending';
    $created_at = date("Y-m-d H:i:s");

    // Create a new order
    $sql = "INSERT INTO orders (user_id, status, created_at) VALUES ('$user_id', '$status', '$created_at')";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Get user's cart items
        $sql = "SELECT ci.product_id, ci.quantity, p.price FROM cart_items ci JOIN products p ON ci.product_id = p.id JOIN carts c ON ci.cart_id = c.id WHERE c.user_id = '$user_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product_id = $row["product_id"];
                $quantity = $row["quantity"];
                $price = $row["price"];

                // Add items to order_items table
                $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$price')";
                $conn->query($sql);
            }

            // Clear user's cart
            $sql = "DELETE FROM cart_items WHERE cart_id = (SELECT id FROM carts WHERE user_id = '$user_id')";
            $conn->query($sql);

            echo "Order placed successfully";
        } else {
            echo "No items in cart";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
