<?php
session_start();
require "dbconfig/config.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />

    <!-- Custom styles for this template -->
    <link href="floating-labels.css" rel="stylesheet" />
</head>

<body>

    <?php
    $movie_name =  "";
    if (isset($_POST["reg_btn"])) {
        $movie_name = $_POST["movie_name"];
        $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));

        // Fill in the query to check if there are any existing records of the username submitted
        $query = "SELECT * from movies WHERE username = '$username' ";
        $query_run = mysqli_query($con, $query);


        // Fill in the query to register the user details into the database
        $query = "INSERT into movies (movie_name,image) VALUES('$movie_name', '$file')";

        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            echo "<script> alert('Successfully Registered!')</script>";
        } else {
            echo "<script> alert('Unable to create')</script>";
        }
    }
    ?>

    <form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="loginbox">

        <div class="text-center mb-4">
            <img class="mb-4" src="bootstrap.png" alt="" width="72" height="72" />
            <h1 class="h3 mb-3 font-weight-normal">Register New Travel Spot</h1>
        </div>

        <div class="form-label-group">
            <input type="movie_name" id="inputMovieName" class="form-control" placeholder="User Name" name="movie_name" required autofocus />
            <label for="inputUserName">Name of Place</label>
        </div>

        <div class="form-label-group">
            <input type="file" id="inputImage" placeholder="Password" name="image" required />
            <label for="inputImage">Upload a cool image!</label>
        </div>

        <input class="btn btn-lg btn-primary btn-block" type="submit" id="registerbtn" value="Register Place" name="reg_btn">

        <button class="btn btn-lg btn-primary btn-block" type="button" value="Back to Review Page" onclick="window.location.href = 'homepage.php'">
            Back to Review Page
        </button>

    </form>
</body>
</html>