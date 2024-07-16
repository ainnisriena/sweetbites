<?php
include 'components/connect.php';
session_start();

// Semak sama ada pengguna telah log masuk
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} 

else {
   $user_id = '';
   header('location: home.php');
   exit();
}

// Tangani penempatan pesanan
if(isset($_POST['submit'])){

   header('Location: home.php');

   
   // Dapatkan data dari borang
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $total_products = filter_var($_POST['total_products'], FILTER_SANITIZE_STRING);
   $total_price = filter_var($_POST['total_price'], FILTER_SANITIZE_STRING);
   $custom_message = filter_var($_POST['custom_message'], FILTER_SANITIZE_STRING);
   $pickup_date = filter_var($_POST['pickup_date'], FILTER_SANITIZE_STRING);
   $pickup_time = filter_var($_POST['pickup_time'], FILTER_SANITIZE_STRING);
   $placed_on = date('Y-m-d H:i:s');
   $payment_status = 'complete';

   // Tangani muat naik fail resit
   $receipt = $_FILES['receipt'];
   $receipt_name = $receipt['name'];
   $receipt_tmp_name = $receipt['tmp_name'];
   $target_dir = "admin/receipts/uploaded_receipts/";
   $target_file = $target_dir . basename($receipt_name);
   $receipt_filename = $target_file; // Tetapkan nama fail kepada pembolehubah

   // Cipta direktori jika tidak wujud
   if (!is_dir($target_dir)) {
      mkdir($target_dir, 0755, true);
   }

   // Lakukan muat naik fail
   if (move_uploaded_file($receipt_tmp_name, $target_file)) {
      $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, total_products, total_price, receipt_filename, placed_on, pickup_date, pickup_time, custom_message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $insert_order->execute([$user_id, $name, $number, $email, $total_products, $total_price, $receipt_filename, $placed_on, $pickup_date, $pickup_time, $custom_message]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $delete_custom_message = $conn->prepare("DELETE FROM `custommessage` WHERE user_id = ?");
      $delete_custom_message->execute([$user_id]);

      $message[] = 'Order placed successfully!';
   } else {
      $message[] = 'Failed to upload receipt!';
   }

   header('Location: home.php');
   exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<!-- Header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- Header section ends -->

<div class="heading">
   <h3>Checkout</h3>
   <p><a href="home.php">Home</a> <span>/ Checkout</span></p>
</div>

<section class="checkout">
   <h1 class="title">Order Summary</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="cart-items">
         <h3>Cart Items</h3>
         <?php
            $grand_total = 0;
            $cart_items = [];
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if($select_cart->rowCount() > 0){
               while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                  $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
         ?>
         <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">RM<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
         <?php
               }
            } else {
               echo '<p class="empty">Your cart is empty!</p>';
            }
         ?>
         <p class="grand-total"><span class="name">Grand Total :</span><span class="price">RM<?= $grand_total; ?></span></p>
         <a href="cart.php" class="btn">View Cart</a>
      </div>

      <input type="hidden" name="total_products" value="<?= $total_products; ?>">
      <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
      <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
      <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
      <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">

      <div class="user-info">
         <h3>Your Info</h3>
         <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
         <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
         <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
         <a href="update_profile.php" class="btn">Update Info</a>

         <p>Click <a href="qr/qr.jpg" target="_blank">here</a> to view or download the QR code.</p>


         <label for="custom_message">Custom Message:</label>
         <textarea id="custom_message" name="custom_message" rows="1" required></textarea>

         <label for="receipt">Upload Receipt:</label>
         <input type="file" name="receipt" id="receipt" required>

         <label for="pickup_date">Pick-up Date:</label>
         <input type="date" id="pickup_date" name="pickup_date" value="<?= $pickup_date ?>" required>

         <label for="pickup_time">Pick-up Time:</label>
         <input type="time" id="pickup_time" name="pickup_time" value="<?= $pickup_time ?>" required>

         
         
         <input type="submit" value="Place Order" class="btn" style="width:100%; background:var(--#F8C8DC); color:var(--black);" name="submit">
      </div>
   </form>
</section>

<!-- Footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- Footer section ends -->

<!-- Custom JS file link  -->
<script src="js/script.js"></script>

</body>
</html>
