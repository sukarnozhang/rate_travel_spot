<?php
session_start();
require "dbconfig/config.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/" />

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />

    <!-- Custom styles for this template -->
    <link href="floating-labels.css" rel="stylesheet" />
</head>

<body>
    <?php
    $username = $password = $cpassword = "";
    if (isset($_POST["reg_btn"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];

        if ($password == $cpassword) {
            // Fill in the query to check if there are any existing records of the username submitted
            $query = "SELECT * from userinfo WHERE username = '$username' ";
            $query_run = mysqli_query($con, $query);

            if (mysqli_num_rows($query_run) > 0) {
                echo "<script> alert('Username taken')</script>";
            } else {
                // Fill in the query to register the user details into the database
                $query = "INSERT into userinfo (username,password) VALUES('$username', '$password')";

                $query_run = mysqli_query($con, $query);

                if ($query_run) {
                    echo "<script> alert('User registered! Proceed to Login.')</script>";
                } else {
                    echo "<script> alert('Unable to create account')</script>";
                }
            }
        } else {
            echo "<script> alert('Passwords do not match!')</script>";
        }
    }
    ?>

    <form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="loginbox">

        <div class="text-center mb-4">
            <img class="mb-4" src="./photos/bootstrap.png" alt="" width="72" height="72" />
            <h1 class="h3 mb-3 font-weight-normal">Register New Accounts</h1>
        </div>

        <div class="form-label-group">
            <input type="usernname" id="inputUserName" class="form-control" placeholder="User Name" name="username" required autofocus />
            <label for="inputUserName">User Name</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required />
            <label for="inputPassword">Password</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="inputCPassword" class="form-control" placeholder="Confirm Password" name="cpassword" required />
            <label for="inputCPassword">Confirm Password</label>
        </div>

        <input class="btn btn-lg btn-primary btn-block" type="submit" id="registerbtn" value="Register Account" name="reg_btn">

        <button class="btn btn-lg btn-primary btn-block" type="button"  value="Back to Login Page" onclick="window.location.href = 'index.php'">
            Back to Login
        </button>

    </form>
</body>
</html>