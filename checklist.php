<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Stops search engines indexing this page -->
		<meta name="robots" content="noindex">

		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!-- Hand made style sheet -->
		<link href="../styles.css" rel="stylesheet" />

		<title>Checky - Checklist</title>
	</head>
	<body>
		<script src="../sharedScripts.js"></script>
		<script src="../checklistScripts.js"></script>
		<script src="../settingsScripts.js"></script>
		<script src="../navBar.js"></script>

		<?php require("../components/navBar.php"); ?>

		<?php require("../components/status-box.html"); ?>

		<div
			id="authenticationBox"
			class="form-box hide"
		>
			<h3>
				Please enter the checklist Password for access to this checklist
			</h3>
			<form onsubmit="ReGrabChecklist();return false">
				<div class="form-row">
					<label for="authPassword"><i class="fas fa-lock"></i><h2>Password:</h2></label>
					<input
						id="authPassword"
						type="password"
					/>
				</div>
				<p id="authPassErrorMsg" class="error-msg"></p>
				<div class="form-row form-row-center">
					<button
						type="submit"
						class="btn"
					>
						Authenticate
					</button>
				</div>
				</div>
			</form>
		</div>

		<div class="ui-checklist-main">
			<div id="taskListDiv" class="hide checklist-container">

				<input id="checklistTitle" class="title" contenteditable="true" onchange="ChangeChecklistTitle()" placeholder="title"></input>

				<table id="taskList" class="table checklist-table">
					<thead>
						<tr>
							<th scope="col" onclick='SortChecklist("checkbox")'></th>
							<th scope="col" onclick='SortChecklist("title")'>Title</th>
							<th scope="col" class="non-important-cell" onclick='SortChecklist("description")'>
								Description
							</th>
							<th scope="col" class="non-important-cell" onclick='SortChecklist("priority")'>
								Priority
							</th>
							<th scope="col" class="non-important-cell" onclick='SortChecklist("status")'>Status</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

				<button class="btn new-task" onclick="NewTask()">New task</button>
			</div>


			<div id="managementBox" class="management-container hide">
				<table class="table management-table">
					<thead>
						<tr>
							<th>Management Settings</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="settingsList">
						<tr id="setPasswordRow" class="hide">
							<td>Set Password</td>
							<td>
								<input
									id="setPassword"
									type="password"
								/>
								<p id="setPassErrorMsg" class="error-msg"></p>
								<div class="text-center">
									<button class="btn" onclick="RequestSetPassword()">Set</button>
								</div>
							</td>
						</tr>
						<tr id="accessRow" class="hide">
							<td>Access Settings</td>
							<td>
								<select
									id="access"
									aria-label=".form-select-lg example"
									onchange="RequestAccessUpdate()"
								>
									<option selected value="Public editable">
										Public editable
									</option>
									<option value="Public not editable">
										Public not editable
									</option>
									<option value="Private">Private</option>
								</select>
							</td>
						</tr>
						<tr id="currentPasswordRow" class="hide">
							<td>Current Password</td>
							<td>
								<input
									id="currentPassword"
									type="password"
									onchange="RemovePasswordError()"
								/>
								<p id="currentPassErrorMsg" class="error-msg"></p>
							</td>
						</tr>
						<tr id="newPasswordRow" class="hide">
							<td>New Password</td>
							<td>
								<input
									id="newPassword"
									type="password"
								/>
								<p id="newPassErrorMsg" class="error-msg"></p>
								<div class="text-center">
									<button class="btn"onclick="RequestChangePassword()">Change</button>
								</div>
							</td>
						</tr>
						<tr id="removePasswordRow" class="hide">
							<td>Remove Password</td>
							<td>
								<div class="text-center">
									<button class="btn" type="button" onclick="RequestRemovePassword()">Remove</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<button id="editButton" type="button" class="hide btn" onclick="RequestReadAccess()">
					Get edit permissions
				</button>

			</div>
		</div>

		<?php require("../components/footer.html"); ?>

	</body>
</html>
