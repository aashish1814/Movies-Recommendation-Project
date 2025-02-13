<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_movie'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $rating = $_POST['rating'];
   $rating = filter_var($rating, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $old_image = $_POST['old_image'];

   $update_movie = $conn->prepare("UPDATE `movies` SET name = ?, category = ?, rating = ?, details = ? WHERE id = ?");
   $update_movie->execute([$name, $category, $rating, $details, $pid]);

   $message[] = 'Movie updated successfully!';

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{

         $update_image = $conn->prepare("UPDATE `movies` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);

         if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_img/'.$old_image);
            $message[] = 'image updated successfully!';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>𝚄𝚙𝚍𝚊𝚝𝚎 𝙼𝚘𝚟𝚒𝚎𝚜</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="update-movie">

   <h1 class="title">Update Movie</h1>   

   <?php
      $update_id = $_GET['update'];
      $select_movies = $conn->prepare("SELECT * FROM `movies` WHERE id = ?");
      $select_movies->execute([$update_id]);
      if($select_movies->rowCount() > 0){
         while($fetch_movies = $select_movies->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_image" value="<?= $fetch_movies['image']; ?>">
      <input type="hidden" name="pid" value="<?= $fetch_movies['id']; ?>">
      <img src="uploaded_img/<?= $fetch_movies['image']; ?>" alt="">
      <input type="text" name="name" placeholder="enter movie name" required class="box" value="<?= $fetch_movies['name']; ?>">
      <select name="category" class="box" required>
         <option selected><?= $fetch_movies['category']; ?></option>
         <option value="action">action</option>
         <option value="thriller">thriller</option>
         <option value="comedy">comedy</option>
         <option value="romantic">romantic</option>
      </select>
      <input type="text" name="rating" placeholder="enter movie imdb rating" required class="box" value="<?= $fetch_movies['rating']; ?>">
      <textarea name="details" required placeholder="enter movie details" class="box" cols="30" rows="10"><?= $fetch_movies['details']; ?></textarea>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <div class="flex-btn">
         <input type="submit" class="btn" value="update movie" name="update_movie">
         <a href="admin_movies.php" class="option-btn">go back</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no Movies found!</p>';
      }
   ?>

</section>













<script src="js/script.js"></script>

</body>
</html>