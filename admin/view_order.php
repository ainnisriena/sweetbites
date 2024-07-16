<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'] ?? null;

if (!$admin_id) {
    header('location: admin_login.php');
    exit;
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Query to fetch order details
    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE `id` = ?");
    $select_order->execute([$order_id]);

    if ($select_order->rowCount() > 0) {
        $fetch_order = $select_order->fetch(PDO::FETCH_ASSOC);
    } else {
        // Handle if order not found
        echo "Order not found.";
        exit;
    }
} else {
    // Handle if order_id parameter is missing
    echo "Order ID parameter is missing.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .heading {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .box {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .box p {
            margin: 5px 0;
        }

        .box span {
            font-weight: bold;
        }

        .box a {
            text-decoration: none;
            color: #007bff;
        }

        .box a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>


<div class="container">
    <h1 class="heading">View Order</h1>
    <div class="box">
    <p> Order ID: <span><?= $fetch_order['id']; ?></span> </p>
        <p> User ID : <span><?= $fetch_order['user_id']; ?></span> </p>
        <p> Name : <span><?= $fetch_order['name']; ?></span> </p>
        <p> Email : <span><?= $fetch_order['email']; ?></span> </p>
        <p> Number : <span><?= $fetch_order['number']; ?></span> </p>
        <p> Total Products : <span><?= $fetch_order['total_products']; ?></span> </p>
        <p> Total Price : <span>RM<?= $fetch_order['total_price']; ?>/-</span> </p>
        <p> Receipt : <a href="../<?= $fetch_order['receipt_filename']; ?>" target="_blank">View Receipt</a> </p>
        <p> Placed On : <span><?= $fetch_order['placed_on']; ?></span> </p>
        <p> Pickup Date : <span><?= $fetch_order['pickup_date']; ?></span> </p>
        <p> Pickup Time : <span><?= $fetch_order['pickup_time']; ?></span> </p>
        <p> Payment Status : <span>Complete</span> </p> <!-- Ubah status pembayaran menjadi "Complete" -->
        <p> Custom Message : <span><?= $fetch_order['custom_message']; ?></span> </p>
        <p> Status : <span><?= $fetch_order['status']; ?></span> </p>
    </div>
</div>


</body>
</html>
