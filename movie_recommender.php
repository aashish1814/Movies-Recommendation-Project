<?php
if (isset($_GET['movie'])) {
    $movie = $_GET['movie'];

    // Define the command to run the Streamlit app on port 8502
    $command = 'streamlit run ./main/movie_recommender.py --server.port 8502';

    // Execute the command to run the Streamlit app
    shell_exec($command);

    // Redirect to the Streamlit app running on the specified port with the movie query
    header("Location: http://localhost:8502/?movie=" . urlencode($movie));
    exit();  // Ensure no further code is executed after the redirection
} else {
    echo "No movie selected.";
}
?>
