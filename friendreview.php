<!-- THERE ARE THREE QUERIES(JOIN, DELETE AND UPDATE) YOU NEED TO FILL FOR THIS FILE. THEY ARE ON LINES 61, 89 and 100 RESPECTIVELY. -->



<?php
	session_start();
	if(!isset($_SESSION['username'])){
   		header("location:index.php");
	}
	require "dbconfig/config.php"
?>

<?php
	if(isset($_GET["name"])){
	$name = $_GET["name"];
	}
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
			if(isset($_POST["logout"])){
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

		<div class="movielist">
			<h2><?= $_GET['user']?>'s reviews</h2>
		</div>


		<div class="container allratings">
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<?php
						// Complete the query(JOIN) to join the movies and movie_reviews table together so that you can display the respective rating for each movie. Use $userid to filter the records so that only the ratings given by the selected user is returned.
						
						$query = "SELECT movies.movie_name, movie_reviews.ratings, movie_reviews.user_id, movie_reviews.movie_id
								FROM movies LEFT JOIN movie_reviews
								ON movies.movie_id = movie_reviews.movie_id
								WHERE movie_reviews.user_id = '$userid'";



						$result = mysqli_query($con, $query);
						while($row = mysqli_fetch_array($result)){
							$movieid = $row['movie_id'];
							$userrating = $row['ratings'];
							$movierated = $row['movie_name'];
							echo '<h2 class="userratings"><span style="color: red;">'.$movierated.' </span><span style="color: yellow;">'.$userrating.'/5</span>';

							if($_GET["user"] == $_SESSION["username"]){		
								echo'<form class="inlineform" method="post" action = " ';
								echo htmlspecialchars('./yourreview.php?user='.$user.'');
								echo '">';
								echo "
								<button name='delrecord' class='deleterec' type='submit'><i class='fas fa-trash-alt'></i></button>
								<input class='hiddeninput' name='movieid' value='$movieid' readonly>
								</form>
								<button class='deleterec updaterec'><i class='fas fa-edit'></i></button>";
								echo '
								<form class="hiddenform" method="post" action = " ';
								echo htmlspecialchars('./yourreview.php?user='.$user.'');
								echo '">';
								echo "
								<input class='rating' type='number' name='rating' step='0.1' min='0' max='5'>
								<input type='submit' value='Rate' name='rate'>
								<input class='hiddeninput' name='movieid' value='$movieid' readonly>
								</form></h2>";
							}								
						}
						if(isset($_POST["delrecord"])){
							$movieid = $_POST["movieid"];
							// Fill in the query to delete a specific movie review given by the current user. Use $userid and $movieid to correctly identify the composite key in the movie_reviews table to delete the specific movie review.
							
							
							$query = "SELECT movie_id from movie_reviews WHERE movie_id ='$movieid' ";
							$query_run = mysqli_query($con, $query);

							if(mysqli_num_rows($query_run)>0){
							$query = "DELETE from movie_reviews WHERE movie_id ='$movieid'";
							}
							// $query_run="";
							$query_run = mysqli_query($con, $query);
							if($query_run){
								echo "<script> alert('Rating removed'); location.href = 'yourreview.php?user=$user'; </script>";
							}
						}

						if(isset($_POST["rate"])){
							$rating = $_POST["rating"];
							$movieid = $_POST["movieid"];
							
							// Fill in the query to update a specific movie review given by the current user. 
							//Use $rating as the new value of rating submitted by the user. 
							//Use $userid and $movieid to correctly identify the composite key in the movie_reviews table to update 
							//the specific movie review.


							$query = "UPDATE movie_reviews SET ratings = '$rating' WHERE user_id = '$userid' AND movie_id = '$movieid'";
							echo "$query";
							$query_run = mysqli_query($con, $query);
							if($query_run){
								echo "<script> alert('Rating changed'); location.href = 'yourreview.php?user=$user'; </script>";
							}
						}
					?>
				</div>
				<div class="col-3"></div>
			</div>
		</div>


		<script>
		$(".updaterec").click(function(){
			$(this.nextElementSibling).toggle();
		});
		</script>

	</body>
</html>
