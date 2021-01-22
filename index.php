<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<link href="style.css" rel="stylesheet" />
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

		<title>Checky - Home</title>
	</head>
	<body>
		<script src="navBar.js"></script>

		<?php require("components/navBar.php"); ?>

		<div>
			<h1>Welcome to Checky</h1>
			<p>Here to make a checklist?<br />Great, click below.</p>
			<a href="createChecklist">
				Create a checklist
			</a>
		</div>

		<?php require("components/footer.php"); ?>

	</body>
</html>
