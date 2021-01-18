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

		<title>Checky - My Checklists</title>
	</head>
	<body>
		<script src="sharedScripts.js"></script>
		<script src="myChecklistsScripts.js"></script>

		<?php require("getNavBar.php"); ?>

		<div id="statusBox">
			<div id="statusLine" class="flexCenter">
				<i class="fas fa-check-circle icon fa-2x" id="successIcon"></i>
				<i class="far fa-times-circle icon fa-2x" id="failIcon"></i>
				<h1 id="statusMsg" class="align-middle"></h1>
			</div>
			<div id="errorMsgLine" class="flexCenter">
				<p id="errorMsg"></p>
			</div>	
		</div>
		
		<div class="container text-center taskList">
			<table
				id="checklistList"
				class="table table-dark table-striped table-hover"
			>
				<thead>
					<tr>
						<th scope="col">Title</th>
						<th scope="col"></th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>

			<button class="btn btn-primary mt-2" onclick="NewChecklist()">
				New checklist
			</button>
		</div>

		<h1 id="notify" class="text-center mt-4"></h1>

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
