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

		<div class="container text-center">
			<div id="main" class="row justify-content-center">
				<div
					id="authenticationBox"
					class="auth-box hide border border-4 border-dark rounded px-3 pt-3"
				>
					<h3 class="mb-3">
						Please enter the checklist Password for access to this checklist
					</h3>
					<form class="has-validation row justify-content-center" onsubmit="ReGrabChecklist();return false">
						<div class="mb-3" style="width: 400px">
							<input
								id="authPassword"
								type="password"
								class="light-grey form-control border border-4 border-dark"
							/>
							<p id="authPassErrorMsg" class="invalid-feedback"></p>
							<div class="text-center m-2">
								<button
									type="submit"
									class="btn btn-primary"
								>
									Authenticate
								</button>
							</div>
						</div>
					</form>
				</div>

				<div id="taskListDiv" class="col-8 hide">

					<input id="checklistTitle" class="form-control" placeholder="checklist title" contenteditable="true" onchange="ChangeChecklistTitle()">

					<table
						id="taskList" 
						class="table table-dark table-striped table-hover"
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

					<button class="btn btn-primary mt-2" onclick="NewTask()">
						New task
					</button>

				</div>
				<div class="col-4 hide" id="managementBox">
					<h1>Management</h1>

					<table class="table table-dark table-striped table-hover">
						<tbody id="settingsList">
							<tr id="setPasswordRow" class="hide">
								<td><h2>Set Password</h2></td>
								<td>
									<input
										id="setPassword"
										type="password"
										class="light-grey form-control border border-4 border-dark"
									/>
									<p id="setPassErrorMsg" class="invalid-feedback"></p>
									<button
										class="btn btn-secondary"
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
										class="form-select light-grey"
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
										class="form-control border border-4 border-dark"
									/>
									<p id="currentPassErrorMsg" class="invalid-feedback"></p>
								</td>
							</tr>
							<tr id="newPasswordRow" class="hide">
								<td><h2>New Password</h2></td>
								<td>
									<input
										id="newPassword"
										type="password"
										class="light-grey form-control border border-4 border-dark"
									/>
									<p id="newPassErrorMsg" class="invalid-feedback"></p>
									<button
										class="btn btn-secondary"
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
										class="btn btn-secondary"
										onclick="RequestRemovePassword()"
									>
										Remove
									</button>
								</td>
							</tr>
						</tbody>
					</table>

					<button id="editButton" type="button" class="btn btn-primary btn-sm hide" onclick="RequestReadAccess()">
						Get edit permissions
					</button>

				</div>
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
		</div>
	</body>
</html>
