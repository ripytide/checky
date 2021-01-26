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

		<title>Checky - My Checklists</title>
	</head>
	<body>
		<script src="sharedScripts.js"></script>
		<script src="myChecklistsScripts.js"></script>
		<script src="navBar.js"></script>

		<?php require("components/navBar.php"); ?>

		<div class="statusBox">
			<div id="statusLine">
				<i class="fas fa-check-circle icon fa-2x" id="successIcon"></i>
				<i class="far fa-times-circle icon fa-2x" id="failIcon"></i>
				<h1 id="statusMsg"></h1>
			</div>
			<div id="errorMsgLine">
				<p id="errorMsg"></p>
			</div>	
		</div>
		
		<div class="taskList">
			<table
				id="checklistList"
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

			<button onclick="NewChecklist()">
				New checklist
			</button>
		</div>

		<?php require("components/footer.html"); ?>

	</body>
</html>
