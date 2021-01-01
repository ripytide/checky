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

		<link href="../style.css" rel="stylesheet" />

		<title>Checky - Checklist</title>
	</head>
	<body>
		<script src="../checklistScripts.js"></script>
		<script src="../settingsScripts.js"></script>

		<?php require("getNavBar.php"); ?>
		
		<div class="container text-center taskList">
			<div class="row justify-content-center">
				<div class="col-8">
			<table id="taskList" class="table table-dark table-striped table-hover">
				<thead>
					<tr>
						<th scope="col" onclick='SortChecklist("checkbox")'></th>
						<th scope="col" onclick='SortChecklist("title")'>Title</th>
						<th scope="col" onclick='SortChecklist("description")'>description</th>
						<th scope="col" onclick='SortChecklist("priority")'>priority</th>
						<th scope="col" onclick='SortChecklist("status")'>status</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>

			<button class="btn btn-primary mt-2" onclick="NewTask()">New task</button>

			</div>
			<div class="col-4">
				<h1>Management</h1>

				<table class="table table-dark table-striped table-hover">
					<tbody id="settingsList">
					</tbody>
				</table>

			</div>
		</div>

		<h1 id="notify" class="text-center mt-4"></h1>

		<button class="btn btn-primary" onclick="GetTasks()">Get tasks</button>

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
