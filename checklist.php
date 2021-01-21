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

		<link href="../style.css" rel="stylesheet" />

		<title>Checky - Checklist</title>
	</head>
	<body>
		<script src="../sharedScripts.js"></script>
		<script src="../checklistScripts.js"></script>
		<script src="../settingsScripts.js"></script>

		<?php require("getNavBar.php"); ?>

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

			<div id="main">
				<div
					id="authenticationBox"
					class="auth-box hide"
				>
					<h3>
						Please enter the checklist Password for access to this checklist
					</h3>
					<form onsubmit="ReGrabChecklist();return false">
						<div>
							<input
								id="authPassword"
								type="password"
							/>
							<p id="authPassErrorMsg"></p>
							<div>
								<button
									type="submit"
								>
									Authenticate
								</button>
							</div>
						</div>
					</form>
				</div>

				<div id="taskListDiv" class="hide">

					<input id="checklistTitle" placeholder="checklist title" contenteditable="true" onchange="ChangeChecklistTitle()">

					<table
						id="taskList"
					>
						<thead>
							<tr>
								<th scope="col" onclick='SortChecklist("checkbox")'></th>
								<th scope="col" onclick='SortChecklist("title")'>Title</th>
								<th scope="col" onclick='SortChecklist("description")'>
									description
								</th>
								<th scope="col" onclick='SortChecklist("priority")'>
									priority
								</th>
								<th scope="col" onclick='SortChecklist("status")'>status</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

					<button onclick="NewTask()">
						New task
					</button>

				</div>
				<div class="managementBox">
					<h1>Management</h1>

					<table>
						<tbody id="settingsList">
							<tr id="setPasswordRow" class="hide">
								<td><h2>Set Password</h2></td>
								<td>
									<input
										id="setPassword"
										type="password"
									/>
									<p id="setPassErrorMsg"></p>
									<button
										onclick="RequestSetPassword()"
									>
										Set
									</button>
								</td>
							</tr>
							<tr id="accessRow" class="hide">
								<td><h2>Access Settings</h2></td>
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
								<td>
									<h2>Current Password</h2>
								</td>
								<td>
									<input
										id="currentPassword"
										type="password"
										onchange="RemovePasswordError()"
									/>
									<p id="currentPassErrorMsg"></p>
								</td>
							</tr>
							<tr id="newPasswordRow" class="hide">
								<td><h2>New Password</h2></td>
								<td>
									<input
										id="newPassword"
										type="password"
									/>
									<p id="newPassErrorMsg"></p>
									<button
										onclick="RequestChangePassword()"
									>
										Change
									</button>
								</td>
							</tr>
							<tr id="removePasswordRow" class="hide">
								<td><h2>Remove Password</h2></td>
								<td>
									<button
										type="button"
										onclick="RequestRemovePassword()"
									>
										Remove
									</button>
								</td>
							</tr>
						</tbody>
					</table>

					<button id="editButton" type="button" class="hide" onclick="RequestReadAccess()">
						Get edit permissions
					</button>

				</div>
			</div>

			<footer>
				<div>
					<span>Copyright© 2020, James Forster, All rights reserved</span>
				</div>
			</footer>

	</body>
</html>
