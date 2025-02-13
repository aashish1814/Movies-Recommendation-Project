<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
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
    <title>🎥Movieplex</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="home-bg">

        <section class="home">

            <div class="content">
                <span>Movieplex</span>
                <h3>"Find Your Next Favorite Film!"</h3>
                <p>
                    "Discover the perfect movie for your mood with ease. Our recommendation system tailors suggestions
                    just
                    for you!"</p>
                <a href="recommend.php" class="btn">Get Recommendation</a>
            </div>

        </section>

    </div>

    <section class="home-category">

        <h1 class="title">Genre Collection</h1>

        <div class="box-container">

            <div class="box">
                <img src="images/avatar.png" alt="">
                <a href="category.php?category=action" class="btn">Action</a>
            </div>

            <div class="box">
                <img src="images/darknight.png" alt="">
                <a href="category.php?category=thriller" class="btn">Thriller</a>
            </div>

            <div class="box">
                <img src="images/mib.png" alt="">
                <a href="category.php?category=comedy" class="btn">Comedy</a>
            </div>

            <div class="box">
                <img src="images/titanix.png" alt="">
                <a href="category.php?category=romantic" class="btn">Romantic</a>
            </div>

        </div>

    </section>

    <section class="movies">
        <h1 class="title">Movie Library</h1>
        <div class="box-container">
            <?php
            // Fetch latest movies from the database (adjust to your actual DB setup)
            $select_movies = $conn->prepare("SELECT * FROM `movies` ORDER BY `date_added` DESC LIMIT 6");
            $select_movies->execute();
            if ($select_movies->rowCount() > 0) {
                while ($fetch_movies = $select_movies->fetch(PDO::FETCH_ASSOC)) {
                    // URL-encode movie name for use in the URL
                    $movie_name_url = urlencode($fetch_movies['name']);
                    $watched = $fetch_movies['watched'] ? "Watched ✅" : "Mark as Watched";
                    ?>
                    <div class="box">
                        <img src="uploaded_img/<?= $fetch_movies['image']; ?>" alt="">
                        <div class="name">
                            <a href="movie_recommender.php?movie=<?= $movie_name_url ?>" target="_blank">
                                <?= $fetch_movies['name']; ?>
                            </a>
                        </div>
                        <div class="rating">IMDB: <?= $fetch_movies['rating']; ?>⭐</div>
                        <form method="POST" action="">
                            <input type="hidden" name="movie_id" value="<?= $fetch_movies['id']; ?>">
                            <button type="submit" name="mark_watched" class="btn"><?= $watched ?></button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">No movies available.</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>