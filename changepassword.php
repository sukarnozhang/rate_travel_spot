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
    $username = $password = $cpassword = "";
    if (isset($_POST["change"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $npassword = $_POST["npassword"];

        $query = "SELECT * from userinfo WHERE username ='$username' AND password = '$password'";
        $query_run = mysqli_query($con, $query);

        if (mysqli_num_rows($query_run) > 0) {
            // Fill in the query to update the user password with the new password that is submitted
            $query = "UPDATE userinfo SET password= '$npassword' WHERE username = '$username'";
            $query_run = mysqli_query($con, $query);
            echo "<script> alert('Password changed')</script>";
        } else {
            echo "<script> alert('Unable to change password')</script>";
        }
    }
    ?>

    <form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="loginbox">
        <div class="text-center mb-4">
            <img class="mb-4" src="./photos/bootstrap.png" alt="" width="72" height="72" />
            <h1 class="h3 mb-3 font-weight-normal">Change Your Password</h1>
        </div>

        <div class="form-label-group">
            <input type="username" id="inputUserName" class="form-control" placeholder="User Name" name="username" required autofocus />
            <label for="inputUserName">User Name</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="inputPassword" class="form-control" placeholder="Old Password" name="password" required />
            <label for="inputPassword">Old Password</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="inputCPassword" class="form-control" placeholder="New Password" name="npassword" required />
            <label for="inputCPassword">New Password</label>
        </div>

        <input class="btn btn-lg btn-warning btn-block" type="submit" id="changebtn" value="Change Password" name="change">

        <button class="btn btn-lg btn-primary btn-block" type="button" value="Back to Login Page" onclick="window.location.href = 'index.php'">
            Back to Login
        </button>

    </form>
</body>
</html>