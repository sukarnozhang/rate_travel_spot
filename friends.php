<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("location:index.php");
}
require "dbconfig/config.php"
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome</title>
	<script src="https://kit.fontawesome.com/b26b33266f.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
</head>

<body>
	<?php
	if (isset($_POST["logout"])) {
		session_destroy();
		header("location:index.php");
	}
	?>

	<?php include("navbar.php"); ?>

	<?php
	$follower = $_SESSION['username'];

	$query = "SELECT user_id FROM userinfo WHERE username = '$follower' ";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	$followerid = $row['user_id'];
	if (isset($_POST["follow"])) {
		$followee = $_POST["followee"];
		$query = "SELECT user_id FROM userinfo WHERE username = '$followee' ";
		$result = mysqli_query($con, $query);
		$row = mysqli_fetch_array($result);
		$followeeid = $row['user_id'];

		$query = "INSERT into user_relation(follower_id, followee_id) VALUES('$followerid', '$followeeid')";
		$query_run = mysqli_query($con, $query);
		if ($query_run) {
			echo "<script> alert('Friend added')</script>";
		} else {
			echo "<script> alert('Already added as friend')</script>";
		}
	}
	?>

	<div class="container-fluid allratings">
		<div class="row">
			<div class="col-6">
				<div class="welcome">
					<h1>
						Your friends
					</h1>
				</div>

				<div class="searchresult">
					<?php
					// Complete this query to join the userinfo and user_relation tables so that you can display the usernames of the friends that the current user has. Use $followerid to filter the records so that only those that are friends with the current user is returned.
					$query = "SELECT userinfo.username, user_relation.follower_id, user_relation.followee_id
								FROM userinfo LEFT JOIN user_relation
								ON userinfo.user_id = user_relation.followee_id
								WHERE user_relation.follower_id = '$followerid'";

					$result = mysqli_query($con, $query);
					while ($row = mysqli_fetch_array($result)) {
						$followee = $row['followee_id'];
						$name = $row['username'];
						echo "<h2><a href='friendreview.php?user=$name'> $name</a>
								";
						echo '
								<form class="inlineform" method="post" action = " ';
						echo htmlspecialchars($_SERVER['PHP_SELF']);
						echo '">';
						echo "
								<h6><button name='delrecord' class='btn-close' type='submit'>x</button></h6></h2>
								<input class='hiddeninput' name='followee' value='$followee' readonly>
								</form>";
					}

					if (isset($_POST["delrecord"])) {
						$followeeid = $_POST["followee"];
						//Fill in this query to delete the selected friend that the current user is following(delete from the user_relation table). $followerid is the id of the current user and $followeeid is the id of the followee that you want to delete.	
						$query = "DELETE FROM user_relation WHERE followee_id=$followeeid";
						$query_run = mysqli_query($con, $query);
						if ($query_run) {
							echo "<script> alert('Friend removed'); location.href = 'friends.php';</script>";
						}
					}
					?>
				</div>
			</div>
			<div class="col-6">
				<div class="welcome">
					<h1>
						Add a friend!
					</h1>
				</div>

				<div class="searchresult">
					<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
						<input type="text" placeholder="Search username" name="user">
						<input type="submit" name="search" placeholder="Search" class="btn btn-primary">
					</form>

					<div class="results">
						<?php
						if (isset($_POST["search"])) {
							$search = $_POST["user"];
							// Fill in this query to select the usernames which contain the search term entered by the user. The search term is stored in $search.
							$query = "SELECT userinfo.username
								FROM userinfo 
								WHERE userinfo.username LIKE '%$search%'";

							$result = mysqli_query($con, $query);
							while ($row = mysqli_fetch_array($result)) {
								$name = $row['username'];
								if ($name != $_SESSION['username']) {
									echo '
											<form method="post" action = " ';
									echo htmlspecialchars($_SERVER['PHP_SELF']);
									echo '">';
									echo "
												<h2 class='namesearched' style='color:blue;'>$name</h2>
												<button class='addfriend' name='follow' style='color:black;'><i class='fas fa-plus-circle' 'style=color:black;'></i></button>
												<input class='hiddeninput' name='followee' value='$name' readonly>
											</form><br>";
								} else {
									echo '<h2>' . $name . '</h2>';
								}
							}
						}
						?>
					</div>
				</div>
			</div>
</body>
</html>