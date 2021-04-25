<?php
session_start();
require "dbconfig/config.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <meta charset="utf-8" />

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />

  <!-- Custom styles for this template -->
  <link href="floating-labels.css" rel="stylesheet" />
  <link rel="stylesheet" href="homepage.css">
  <script src="anime.js"></script>
</head>

<body>
  <?php
  $username = $password = "";
  if (isset($_POST["signin"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Fill in the blank query here to allow user to log into the page
    $query = "SELECT * from userinfo WHERE username = '$username' AND password = '$password' ";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
      $_SESSION["username"] = $username;
      header("location:homepage.php");
    } else {
      echo "<script> alert('Username or Password is incorrect.')</script>";
    }
  }
  ?>
  
  <form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="loginbox">

    <div class="text-center mb-4">
      <img class="mb-4" src="./photos/bootstrap.png" alt="" width="72" height="72" />
      <h1 class="h3 mb-3 font-weight-normal">Travel Rate</h1>
    </div>

    <div class="form-label-group">
      <input type="username" id="inputUserName" class="form-control" placeholder="Uer Nsame" name="username" required autofocus />
      <label for="inputUserName">User Name</label>
    </div>

    <div class="form-label-group">
      <input type="password" id="inputPassword" class="form-control" placeholder="password1" name="password" required />
      <label for="inputPassword">Password</label>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit" name="signin">
      Sign in
    </button>

    <button class="btn btn-lg btn-primary btn-block" type="button" name="register" value="Register" onclick="window.location.href = 'register.php'">
      Register
    </button>

    <button class="btn btn-lg btn-warning btn-block" type="button" name="delete" value="Delete Your Account" onclick="window.location.href = 'delete.php'">
      Delete Account
    </button>

    <button class="btn btn-lg btn-warning btn-block" type="button" name="change" onclick="window.location.href = 'changepassword.php'">
      Change Password
    </button>

  </form>
</html>