<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>𝚊𝚋𝚘𝚞𝚝</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="box">
         <img src="images/movie.png" width="500px" alt="">
         <h3>why choose us?</h3>
         <p>Our system provides best Movie recommendation for User</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

      <div class="box">
         <img src="images/recomend.png" width="500px" alt="">
         <h3>what we provide?</h3>
         <p>Best Movie Recommendation according to geners and user review provided</p>
         <a href="recommend.php" class="btn">Recommend Movies</a>
      </div>

   </div>

</section>



</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>