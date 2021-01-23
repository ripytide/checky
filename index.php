<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!-- Hand made style sheet -->
		<link href="../styles.css" rel="stylesheet" />

		<!-- Lato font -->
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

		<title>Checky - Home</title>
	</head>
	<body>
		<script src="navBar.js"></script>

		<?php require("components/navBar.php"); ?>

		<div class="main">
			<h1>Welcome to Checky</h1>
			<p>Here to make a checklist?<br />Great, click below.</p>
			<a class="link" href="/createChecklist">
				Create a checklist
			</a>
		</div>

		<?php require("components/footer.html"); ?>

	</body>
</html>
