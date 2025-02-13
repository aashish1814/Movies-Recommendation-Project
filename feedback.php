<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Feedback</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-pzjw8f+ua7Kw1TIq0Hn7fI2xRe7zB20t2v0+f5gf5Ke4t5MChv5Z3M71hv5Hk09A" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

   <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f7fc;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.2rem;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }
        .card-body {
            background-color: #ffffff;
            padding: 20px;
        }
        .progress-bar {
            background-color: #28a745;
        }
        .star-light {
            color: #e9ecef;
        }
        .star-rating i {
            font-size: 2rem;
            cursor: pointer;
        }
        .star-rating i:hover {
            color: #f0ad4e;
        }
        .review-card {
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .review-card-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }
        .review-card-body {
            padding: 15px;
            background-color: #f8f9fa;
        }
        .review-card-footer {
            text-align: right;
            background-color: #f8f9fa;
            padding: 5px;
            border-radius: 0 0 10px 10px;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .modal-footer {
            background-color: #f8f9fa;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: bold;
        }
    </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">Post Your Review & Rating</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <h1 class="text-warning mt-4 mb-4"><b><span id="average_rating">0.0</span> / 5</b></h1>
                    <div class="star-rating">
                        <i class="fas fa-star star-light main_star"></i>
                        <i class="fas fa-star star-light main_star"></i>
                        <i class="fas fa-star star-light main_star"></i>
                        <i class="fas fa-star star-light main_star"></i>
                        <i class="fas fa-star star-light main_star"></i>
                    </div>
                    <h3><span id="total_review">0</span> Reviews</h3>
                </div>
                <div class="col-sm-4">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                    </div>
                    <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                    <div class="progress-label-right"><span id="total_five_star_review">0</span></div>
                </div>
                <div class="col-sm-4 text-center">
                    <button type="button" class="btn btn-primary" id="add_review">Write a Review</button>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5" id="review_content"></div>
</div>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

<!-- Modal for Review -->
<div id="review_modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Your Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="star-rating mb-3">
                    <i class="fas fa-star star-light submit_star" id="submit_star_1" data-rating="1"></i>
                    <i class="fas fa-star star-light submit_star" id="submit_star_2" data-rating="2"></i>
                    <i class="fas fa-star star-light submit_star" id="submit_star_3" data-rating="3"></i>
                    <i class="fas fa-star star-light submit_star" id="submit_star_4" data-rating="4"></i>
                    <i class="fas fa-star star-light submit_star" id="submit_star_5" data-rating="5"></i>
                </div>
                <input type="text" class="form-control mb-3" id="user_name" placeholder="Enter Your Name">
                <textarea class="form-control" id="user_review" placeholder="Type Your Review Here"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save_review">Submit Review</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    var rating_data = 0;

    $('#add_review').click(function(){
        $('#review_modal').modal('show');
    });

    $(document).on('mouseenter', '.submit_star', function(){
        var rating = $(this).data('rating');
        reset_background();
        for(var count = 1; count <= rating; count++){
            $('#submit_star_' + count).addClass('text-warning');
        }
    });

    function reset_background() {
        for(var count = 1; count <= 5; count++) {
            $('#submit_star_' + count).removeClass('text-warning').addClass('star-light');
        }
    }

    $(document).on('mouseleave', '.submit_star', function(){
        reset_background();
        for(var count = 1; count <= rating_data; count++) {
            $('#submit_star_' + count).removeClass('star-light').addClass('text-warning');
        }
    });

    $(document).on('click', '.submit_star', function(){
        rating_data = $(this).data('rating');
    });

    $('#save_review').click(function(){
        var user_name = $('#user_name').val();
        var user_review = $('#user_review').val();
        if(user_name == '' || user_review == '') {
            alert("Please fill both fields!");
            return false;
        } else {
            $.ajax({
                url: "feedback_submit_rating.php",
                method: "POST",
                data: {rating_data: rating_data, user_name: user_name, user_review: user_review},
                success: function(data){
                    $('#review_modal').modal('hide');
                    load_rating_data();
                    alert(data);
                }
            });
        }
    });

    load_rating_data();

    function load_rating_data() {
        $.ajax({
            url: "feedback_submit_rating.php",
            method: "POST",
            data: {action: 'load_data'},
            dataType: "JSON",
            success: function(data){
                $('#average_rating').text(data.average_rating);
                $('#total_review').text(data.total_review);

                var count_star = 0;
                $('.main_star').each(function(){
                    count_star++;
                    if(Math.ceil(data.average_rating) >= count_star) {
                        $(this).addClass('text-warning');
                    }
                });

                $('#total_five_star_review').text(data.five_star_review);
                $('#five_star_progress').css('width', (data.five_star_review/data.total_review) * 100 + '%');
                
                if(data.review_data.length > 0) {
                    var html = '';
                    for(var count = 0; count < data.review_data.length; count++) {
                        html += '<div class="review-card">';
                        html += '<div class="review-card-header">' + data.review_data[count].user_name + '</div>';
                        html += '<div class="review-card-body">';
                        for(var star = 1; star <= 5; star++) {
                            var class_name = (data.review_data[count].rating >= star) ? 'text-warning' : 'star-light';
                            html += '<i class="fas fa-star ' + class_name + '"></i>';
                        }
                        html += '<p>' + data.review_data[count].user_review + '</p>';
                        html += '</div>';
                        html += '<div class="review-card-footer">On ' + data.review_data[count].datetime + '</div>';
                        html += '</div>';
                    }
                    $('#review_content').html(html);
                }
            }
        });
    }
});
</script>
</body>
</html>
