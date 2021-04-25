<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
require "dbconfig/config.php"
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Album example · Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />

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
    <?php include("navbar.php"); ?>

    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1>Welcome <?= $_SESSION['username']; ?>! </h1>
                <br></br>
                <p class="lead text-muted">Choose a Travel Spot to Review</p>
                <button class="btn btn-primary" type="button" name="register" value="Register" onclick="window.location.href = 'addplace.php'">
                    Alternatively, Add a New Travel Spot
                </button>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <?php
                    $query = "SELECT movie_name, image FROM movies";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        $name = $row['movie_name'];
                        $image = $row['image'];

                        echo '
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <img class="bd-placeholder-img card-img-top" src="data:image/jpeg;base64,' . base64_encode($image) . '" width="100%" height="425" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
                                </img>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                        <a class="card-text"> ' . $name . ' </a>
                                            <a href="review.php?name=' . $name . '"><button  type="button" class="btn btn-sm btn-outline-secondary">Rate</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
            </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    
</html>