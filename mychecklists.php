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

		<?php require("components/status-box.html"); ?>
		
		<div class="flex-center">
			<div>
				<table id="checklistList" class="table">
					<thead>
						<tr>
							<th scope="col">Title</th>
							<th scope="col"></th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

				<button onclick="NewChecklist()" class="btn">
					New checklist
				</button>
			</div>
		</div>

		<?php require("components/footer.html"); ?>

	</body>
</html>
