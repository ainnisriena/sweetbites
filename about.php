<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

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
   <h3>about us</h3>
   <p><a href="home.php">home</a> <span> / about</span></p>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/baker.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Welcome to Sweet Bites Dessert, where indulgence meets convenience! Our journey began with a shared passion for crafting delectable desserts that not only satisfy sweet cravings but also elevate the dessert experience. Founded in 2020, we have dedicated ourselves to bringing joy to dessert lovers through the convenience of online ordering.</p>
         <p>At Sweet Bites Dessert, we believe that desserts are more than just sweet treats; they are moments of joy, celebrations, and expressions of love. Our team of skilled pastry chets and dessert enthusiasts work tirelessly to create an array of mouthwatering desserts that cater to diverse tastes and preferences.</p>
         <p>What sets us apart is our commitment to quality and freshness. We source only the finest ingredients to ensure that each dessert is a perfect balance of flavers and textures From classic faverites to Innovative creations, our menu is a testament to our dedication to culinary excellence.</p>
         <a href="menu.php" class="btn">our menu</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->

<section class="steps">

   <h1 class="title">simple steps</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/choose.jpg" alt="">
         <h3>choose order</h3>
         <p> "Browse our menu and select your favorite dishes to create your order."</p>
      </div>

      <div class="box">
         <img src="images/pickup.png" alt="">
         <h3>pick-up</h3>
         <p>"Pickup your dessert fresh from us."</p>
      </div>

      <div class="box">
         <img src="images/enjoy.jpg" alt="">
         <h3>enjoy food</h3>
         <p>"Savor your meal and enjoy a delightful dining experience at home."</p>
      </div>

   </div>

</section>

<!-- steps section ends -->

<!-- reviews section starts  -->

<section class="reviews">

   <h1 class="title">customer's reviews</h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

      <?php
         // Fetch reviews from the database
         $select_reviews = $conn->prepare("SELECT reviews.*, users.name FROM `reviews` JOIN `users` ON reviews.user_id = users.id ORDER BY reviews.created_at DESC");
         $select_reviews->execute();

         // Check if there are reviews
         if($select_reviews->rowCount() > 0){
            while($fetch_reviews = $select_reviews->fetch(PDO::FETCH_ASSOC)){
         ?>
         <div class="swiper-slide slide">
            <img src="images/user-profile.jpg" alt="">
            <p>"<?= htmlspecialchars($fetch_reviews['review']); ?>"</p>
            <div class="stars">
               <?php
                  for($i = 0; $i < 5; $i++){
                     if($i < $fetch_reviews['rating']){
                        echo '<i class="fas fa-star"></i>';
                     } else {
                        echo '<i class="fas fa-star-half-alt"></i>';
                     }
                  }
               ?>
            </div>
            <h3><?= htmlspecialchars($fetch_reviews['name']); ?></h3>
         </div>
         <?php
            }
         } else {
            echo '<p class="empty">no reviews yet!</p>';
         }
         ?>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<!-- reviews section ends -->



















<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->=






<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
      slidesPerView: 1,
      },
      700: {
      slidesPerView: 2,
      },
      1024: {
      slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>