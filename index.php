<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Bootstrap CSS -->
		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
			crossorigin="anonymous"
		/>

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<link href="style.css" rel="stylesheet" />

		<title>Checky - Home</title>
	</head>
	<body>
		<script src="indexScripts.js"></script>

		<?php require("getNavBar.php"); ?>

		<div class="container text-center">
			<h1 class="fs-1" style="margin-top: 10%">Welcome to Checky</h1>
			<p class="mt-4">Here to make a checklist?<br />Great, click below.</p>
			<a class="dark-blue btn btn-lg mt-5" href="createChecklist">
				Create a checklist
			</a>
			<a class="dark-blue btn btn-lg mt-5" href="mychecklists">
				my checklists
			</a>
		</div>

		<footer>
			<div class="container text-center p-3">
				<span>Copyright© 2020, James Forster, All rights reserved</span>
			</div>
		</footer>

		<!-- Bootstrap JS -->
		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
			crossorigin="anonymous"
		></script>
	</body>
</html>
