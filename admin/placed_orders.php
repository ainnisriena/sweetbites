<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'] ?? null;

if (!$admin_id) {
    header('location: admin_login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['mark_completed'])) {
    // Validate and sanitize input
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : null;

    if ($order_id !== null) {
        // Update order status to 'completed'
        $update_order_status = $conn->prepare("UPDATE `orders` SET `status` = 'completed' WHERE `id` = ?");
        $update_order_status->execute([$order_id]);
        
    } 
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location: placed_orders.php');
    exit;
}

$select_orders = $conn->prepare("SELECT * FROM `orders`");
$select_orders->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placed Orders</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="placed-orders">
    <h1 class="heading">Placed Orders</h1>
    <div class="box-container">

    <?php
    if ($select_orders->rowCount() > 0) {
        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
    ?>

    <div class="box">
        <p> Order ID: <span><?= $fetch_orders['id']; ?></span> </p>
        <p> User ID : <span><?= $fetch_orders['user_id']; ?></span> </p>
        <p> Name : <span><?= $fetch_orders['name']; ?></span> </p>
        <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
        <p> Number : <span><?= $fetch_orders['number']; ?></span> </p>
    
        <!-- Order Status -->
        <p> Order Status : 
            <?php if ($fetch_orders['status'] == 'cancelled') { ?>
                <span style="color: red;"><?= $fetch_orders['status']; ?></span>
            <?php } else { ?>
                <span><?= $fetch_orders['status']; ?></span>
            <?php } ?>
        </p>

        <!-- View Order button/link -->
        <a href="view_order.php?order_id=<?= $fetch_orders['id']; ?>" class="btn">View Order</a>
        
        <!-- Mark as Completed Form -->
        <?php if ($fetch_orders['status'] != 'completed') { ?>
            <form action="" method="POST">
                <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                <input type="submit" value="Mark as Completed" class="btn" name="mark_completed">
            </form>
        <?php } ?>

        <!-- Delete Order link -->
        <div class="flex-btn">
            <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
        </div>
    </div>

    <?php
        }
    } else {
        echo '<p class="empty">No orders placed yet!</p>';
    }
    ?>

    </div>
</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
