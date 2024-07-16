<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};


if (isset($_POST['submit_review'])) {
   $order_id = $_POST['order_id'];
   $review = $_POST['review'];
   $review = filter_var($review, FILTER_SANITIZE_STRING);

   // Validate rating
   if (isset($_POST['rating'])) {
       $rating = $_POST['rating'];
       $rating = filter_var($rating, FILTER_SANITIZE_NUMBER_INT);

       $check_order_status = $conn->prepare("SELECT * FROM `orders` WHERE id = ? AND user_id = ?");
        $check_order_status->execute([$order_id, $user_id]);
        $order_details = $check_order_status->fetch(PDO::FETCH_ASSOC);

        if ($order_details['status'] == 'cancelled') {
            $message[] = 'You cannot review a cancelled order!';
        } else {


       // Check if a review already exists for this order by this user
       $check_review = $conn->prepare("SELECT * FROM `reviews` WHERE user_id = ? AND order_id = ?");
       $check_review->execute([$user_id, $order_id]);

       if ($check_review->rowCount() > 0) {
           $message[] = 'You have already reviewed this order!';
       } else {
           $insert_review = $conn->prepare("INSERT INTO `reviews` (user_id, order_id, review, rating) VALUES (?, ?, ?, ?)");
           $insert_review->execute([$user_id, $order_id, $review, $rating]);
           $message[] = 'Review submitted successfully!';
       }
   }
   } else {

       $message[] = 'Please select a rating!';
   }
}

if (isset($_POST['cancel_order'])) {
   $order_id = $_POST['order_id'];

   // Update order status to 'cancelled'
   $update_order_status = $conn->prepare("UPDATE `orders` SET `status` = 'cancelled' WHERE `id` = ?");
   $update_order_status->execute([$order_id]);

  

   $message[] = 'Order cancelled successfully!';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>orders</h3>
   <p><a href="html.php">home</a> <span> / orders</span></p>
</div>

<section class="orders">

   <h1 class="title">your orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>total price : <span>RM<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p>pickup_date : <span><?= $fetch_orders['pickup_date']; ?></span></p>
      <p>pickup_time : <span><?= $fetch_orders['pickup_time']; ?></span></p>
      <p>payment status : <span style="color:green;">success</span> </p>

      <?php

         // Check if a review can be submitted
      $can_review = true; // Default to true

         // Check if order status is pending and review doesn't exist
      if ($fetch_orders['status'] == 'cancelled') {
      $can_review = false;
}
         // Check if a review already exists for this order by this user
         $check_review = $conn->prepare("SELECT * FROM `reviews` WHERE user_id = ? AND order_id = ?");
         $check_review->execute([$user_id, $fetch_orders['id']]);
         if($check_review->rowCount() == 0){
            
      ?>


      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <textarea name="review" placeholder="Write your review here" required></textarea>
         <select name="rating" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
         </select>
         <input type="submit" name="submit_review" value="Submit Review" class="btn">
         </form>

<?php
         } else {
            // Display the existing review
            $fetch_review = $check_review->fetch(PDO::FETCH_ASSOC);
            echo '<p class="review">Your review: ' . htmlspecialchars($fetch_review['review']) . '</p>';
            echo '<p class="rating">Rating: ' . htmlspecialchars($fetch_review['rating']) . ' stars</p>';
         }
      ?>

   <?php if ($fetch_orders['status'] == 'pending' && $check_review->rowCount() == 0) { ?>
   <form action="" method="POST">
            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
            <input type="submit" name="cancel_order" value="Cancel Order" class="btn">
        </form>

      <?php } else { ?>
        <p>Order Status: <span><?= $fetch_orders['status']; ?></span></p>
      <?php } ?>
   </div>

   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>

</section>










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>