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
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/">

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
</head>

<body>
    <?php
    if (isset($_POST["logout"])) {
        session_destroy();
        header("location:index.php");
    }
    ?>

    <?php
    $user = $_SESSION['username'];
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
                <p class="lead text-muted">Please Rate the Places Below</p>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <?php
                    $place = $_GET["name"];
                    $query = "SELECT place_id, image FROM place WHERE place_name = '$place'";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_array($result);
                    $placeid = $row['place_id'];

                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        $placeid = $row['place_id'];
                        $image = $row['image'];

                        echo '
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <img class="bd-placeholder-img card-img-top" src="data:image/jpeg;base64,' . base64_encode($image) . '" width="10%" height="425" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
                                </img>
                                <div class="card-body">
                                <a class="card-text"> ' . $name . ' </a>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="center2">
                                            <form method="post">
                                                <input class="rating" type="number" name="rating" step="0.1" min="0" max="5">
                                                <input type="submit" value="Rate" name="rate">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>

                    <?php
                    $rating = "";
                    if (isset($_POST["rate"])) {
                        $rating = $_POST["rating"];

                        // Fill in the query to insert the rating into the database. 
                        $query = "INSERT into place_review VALUES('$userid', '$placeid', '$rating')";

                        $query_run = mysqli_query($con, $query);
                        if ($query_run) {
                            echo "<script> alert('Rating added')</script>";
                        } else {
                            echo " <script> alert('You have already rated, please edit your previous review')</script>";
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="container allratings">
                <div class="row">
                    <div></div>
                    <div>
                        <h2>All Ratings</h2>
                        <?php
                        $placename = $_GET['name'];
                        $query = "SELECT place_id FROM place WHERE place_name = '$placename' ";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_array($result);
                        $placeid = $row['place_id'];

                        // Fill in the query(JOIN) to join the userinfo and movie_reviews table together so that you can display the respective rating given by each username. Use $movieid to filter the records so that only the ratings for the selected movie is shown.
                        $query = "SELECT userinfo.username, place_review.ratings
						FROM userinfo LEFT JOIN place_review
						ON userinfo.user_id = place_review.user_id
						WHERE place_review.place_id = '$placeid'";

                        $result = mysqli_query($con, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            $userrating = $row['ratings'];
                            $userthatrated = $row['username'];
                            echo '<h2 class="userratings"><span style="color: red;">' . $userthatrated . '</span> gives a rating of <span style="color: black;">' . $userrating . '/5</span></h2>';
                        }
                        ?>
                    </div>
                    <div class="col-3"></div>
                </div>
            </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

</html>