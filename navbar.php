<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
</head>

<body>
	<nav class="navbar navbar-dark bg-primary" style="color: black;">
		<div class="container-fluid">
			<a class="navbar-brand" href="homepage.php"><img src="photos/film.png" width=40px></a>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="navbar-brand" href="yourreview.php?user=<?php echo $_SESSION['username']; ?>"> Your Reviews </a>
					<a class="navbar-brand" href="friends.php"> Friends </a>
				</li>
			</ul>

			<form method="post" class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
				<button class="btn btn-lg btn-warning btn-block" type="submit" name="logout">Logout</button>
			</form>
		</div>
	</nav>
</body>