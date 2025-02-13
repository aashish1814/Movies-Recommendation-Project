<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
   exit;
}

// Handle "Mark as Watched" functionality
if (isset($_POST['mark_watched'])) {
    $movie_id = $_POST['movie_id'];
    // Toggle the watched status
    $update_query = $conn->prepare("UPDATE `movies` SET `watched` = NOT `watched` WHERE `id` = ?");
    $update_query->execute([$movie_id]);
    header("Refresh:0"); // Refresh to update the UI
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Movies Category</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File -->
   <link rel="stylesheet" href="css/style.css">
</head>

<body>

   <?php include 'header.php'; ?>

   <section class="movies">

      <h1 class="title">Movies Categories</h1>

      <div class="box-container">

         <?php
         // Get the category from the URL or set a default empty value
         $category_name = $_GET['category'] ?? '';
         $category_name = filter_var($category_name, FILTER_SANITIZE_STRING);

         // Prepare the SQL statement, now sorting by `date_added` to get latest movies first and without LIMIT
         $select_movies = $conn->prepare("SELECT * FROM `movies` WHERE category = ? ORDER BY `date_added` DESC");
         $select_movies->execute([$category_name]);

         // Display movies if found
         if ($select_movies->rowCount() > 0) {
            while ($fetch_movies = $select_movies->fetch(PDO::FETCH_ASSOC)) {
               $movie_name_url = urlencode($fetch_movies['name']);
               $watched = $fetch_movies['watched'] ? "Watched ✅" : "Mark as Watched";
               ?>
               <div class="box">
                  <img src="uploaded_img/<?= htmlspecialchars($fetch_movies['image']); ?>" alt="">

                  <div class="name">
                     <!-- Movie title is clickable -->
                     <a href="movie_recommender.php?movie=<?= $movie_name_url; ?>&category=<?= urlencode($category_name); ?>" target="_self">
                        <?= htmlspecialchars($fetch_movies['name']); ?>
                     </a>
                  </div>
                  <div class="rating">IMDB: <?= htmlspecialchars($fetch_movies['rating']); ?>⭐</div>

                  <!-- Mark as Watched button -->
                  <form method="POST" action="">
                     <input type="hidden" name="movie_id" value="<?= $fetch_movies['id']; ?>">
                     <button type="submit" name="mark_watched" class="btn"><?= $watched ?></button>
                  </form>
               </div>
               <?php
            }
         } else {
            echo '<p class="empty">No Movies available!</p>';
         }
         ?>

      </div>

   </section>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>
