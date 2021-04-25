<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
require "dbconfig/config.php"
?>

<?php
if (isset($_GET["name"])) {
    $name = $_GET["name"];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Album example · Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="homepage.css" rel="stylesheet">
    <script src="anime.js"></script>
</head>

<body>
    <?php
    if (isset($_POST["logout"])) {
        session_destroy();
        header("location:index.php");
    }
    ?>

    <?php
    $user = $_GET['user'];
    $query = "SELECT user_id FROM userinfo WHERE username = '$user'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $userid = $row['user_id'];
    ?>

    <?php include("navbar.php"); ?>

    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1>Welcome <?= $_SESSION['username']; ?>! </h1>
                <br></br>
                <p class="lead text-muted">Below are the travel spots rated by you</p>

            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">

                    <?php
                    // Complete the query(JOIN) to join the movies and movie_reviews table together so that you can display the respective rating for each movie. Use $userid to filter the records so that only the ratings given by the selected user is returned.
                    $query = "SELECT place.place_name, place.image, place_review.ratings, place_review.user_id, place_review.place_id
								FROM place LEFT JOIN place_review
								ON place.place_id = place_review.place_id
								WHERE place_review.user_id = '$userid'";

                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        $placeid = $row['place_id'];
                        $userrating = $row['ratings'];
                        $placerated = $row['place_name'];
                        $image = $row['image'];

                        if ($_GET["user"] == $_SESSION["username"]) {
                        echo '
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <img class="bd-placeholder-img card-img-top" src="data:image/jpeg;base64,' . base64_encode($image) . '" width="10%" height="425" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
                                </img>
                                <div class="card-body">
                                <p class="card-text"> ' . $name . ' </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <p class="class="card-text"> ' . $placerated . '</p>
                                            <p class="btn btn-sm btn-outline-secondary"><span style="color: black;">  Rated Score : ' . $userrating . '/5</span></p>
                                            <a class="card-text"> ' . $name . ' </a>
                                            <form method="post" action = " ./yourreview.php?user=' . $user . '">
                                                <button name="delrecord" class="btn btn-sm btn-outline-secondary" type="submit"><i class="fas fa-trash-alt"></i>X</button>
                                                <input style="display:none;" class="hiddeninput" name="placeid" value="' . $placeid . '" readonly> 
                                                &nbsp;  &nbsp; &nbsp; 
                                                <input class="btn btn-sm btn-outline-secondary" type="number" name="rating" step="0.1" min="0" max="5">
                                                <input class="btn btn-sm btn-outline-secondary" type="submit" value="Rate" name="rate" >
                                                <input style="display:none;" class="hiddeninput" name="placeid" value="' . $placeid . '" readonly>
                                             </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        }
                    }
                    if (isset($_POST["delrecord"])) {
                        $placeid = $_POST["placeid"];
                        // Fill in the query to delete a specific movie review given by the current user. Use $userid and $movieid to correctly identify the composite key in the movie_reviews table to delete the specific movie review.
                        $query = "SELECT place_id from place_review WHERE place_id ='$placeid' ";
                        $query_run = mysqli_query($con, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            $query = "DELETE from place_review WHERE place_id ='$placeid'";
                        }
                        $query_run = mysqli_query($con, $query);
                        if ($query_run) {
                            echo "<script> alert('Rating removed'); location.href = 'yourreview.php?user=$user'; </script>";
                        }
                    }

                    if (isset($_POST["rate"])) {
                        $rating = $_POST["rating"];
                        $placeid = $_POST["placeid"];

                        // Fill in the query to update a specific movie review given by the current user. 
                        //Use $rating as the new value of rating submitted by the user. 
                        //Use $userid and $movieid to correctly identify the composite key in the movie_reviews table to update 
                        //the specific movie review.
                        $query = "UPDATE place_review SET ratings = '$rating' WHERE user_id = '$userid' AND place_id = '$placeid'";
                        echo "$query";
                        $query_run = mysqli_query($con, $query);
                        if ($query_run) {
                            echo "<script> alert('Rating changed'); location.href = 'yourreview.php?user=$user'; </script>";
                        }
                    }
                    ?>
                </div>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="button" value="Back to Review Page" onclick="window.location.href = 'homepage.php'">
                Back to Review Page
            </button>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="anime.js"></script>

</html>