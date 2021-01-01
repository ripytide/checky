var allowSet = true;
var allowChange = true;
var allowRemove = true;
var currentAccess;

$(document).ready(function () {
	GetSettings();
});

function GetSettings() {
	$.post(
		"../../Back-End/Checklist/Settings/getSettings.php",
		{ checklistID: GetChecklistID() },
		GetSettingsReturned
	);
}

function GetSettingsReturned(data) {
	var json = JSON.parse(data);

	if (json["status"] === "success") {
		if (json["userChecklist"]) {
			AddAccessRow(json["access"]);
			currentAccess = json["access"];
		} else {
			if (json["passwordSet"]) {
				AddSetPasswordRows(json["access"]);
				currentAccess = json["access"];
			} else {
				AddUnsetPasswordRows();
			}
		}
	} else {
		DisplayInfo(json["errorMsg"]);
	}
}

function RequestAccessUpdate() {
	var newValue = this.value;

	var dataOutwards = {
		column: "access",
		newValue,
		checklistID: GetChecklistID(),
		password: GetPassword(),
	};

	$.post(
		"../../Back-End/Checklist/Settings/updateSettings.php",
		dataOutwards,
		UpdateSettingReturned
	);
}

function UpdateSettingReturned(data) {
	json = JSON.parse(data);

	if (json["status"] === "success") {
		DisplayInfo(json["status"]);
		CurrentPasswordError("");
		currentAccess = json["access"];
	} else {
		DisplayInfo(json["status"]);
		CurrentPasswordError(json["currentPassErrorMsg"]);

		document
			.getElementById("accessRow")
			.getElementsByTagName("select")[0].value = currentAccess;
	}
}

function RequestSetPassword() {
	if (allowSet) {
		var password = document.getElementById("setPassword").value;

		var dataOutwards = { password, checklistID: GetChecklistID() };

		$.post(
			"../../Back-End/Checklist/Settings/setPassword.php",
			dataOutwards,
			SetPasswordReturned
		);

		allowSet = false;
	}
}

function SetPasswordReturned(data) {
	var json = JSON.parse(data);

	passErrorMsg = document.getElementById("setPassErrorMsg");

	passInput = document.getElementById("setPassword");

	if (json["passErrorMsg"] != "") {
		passErrorMsg.innerHTML = json["passErrorMsg"];
		passInput.classList.add("is-invalid");
	} else {
		document.getElementById("setPasswordRow").remove();
		AddSetPasswordRows("Public editable");
		currentAccess = "Public editable";
	}

	allowSet = true;
}

function AddSetPasswordRows(access) {
	var table = document.getElementById("settingsList");

	AddAccessRow(access);

	var row2 = table.insertRow();
	row2.id = "currentPasswordRow";
	row2.innerHTML =
		'<td><h2>Current Password</h2></td><td><input id="currentPassword" type="password" class="light-grey form-control border border-4 border-dark"/><p id="currentPassErrorMsg" class="invalid-feedback"></p></td>';

	var row3 = table.insertRow();
	row3.id = "newPasswordRow";
	row3.innerHTML =
		'<td><h2>New Password</h2></td><td><input id="newPassword" type="password" class="light-grey form-control border border-4 border-dark"/><p id="newPassErrorMsg" class="invalid-feedback"></p><button class="btn btn-secondary" onclick="RequestChangePassword()">Change</button></td>';

	var row4 = table.insertRow();
	row4.id = "removePasswordRow";
	row4.innerHTML =
		'<td><h2>Remove Password</h2></td><td><button type="button" class="btn btn-secondary" onclick="RequestRemovePassword()">Remove</button></td>';
}

function AddUnsetPasswordRows() {
	var table = document.getElementById("settingsList");

	var row = table.insertRow();
	row.id = "setPasswordRow";
	row.innerHTML =
		'<td><h2>Set Password</h2></td><td><input id="setPassword" type="password" class="light-grey form-control border border-4 border-dark"/><p id="setPassErrorMsg" class="invalid-feedback"></p><button class="btn btn-secondary" onclick="RequestSetPassword()">Set</button></td>';
}

function AddAccessRow(access) {
	var table = document.getElementById("settingsList");

	var row = table.insertRow();
	row.id = "accessRow";
	row.innerHTML =
		'<td><h2>Access Settings</h2></td><td><select class="form-select light-grey" aria-label=".form-select-lg example"><option selected value="Public editable">Public editable</option><option value="Public not editable">Public not editable</option><option value="Private">Private</option></select></td>';
	row
		.getElementsByTagName("select")[0]
		.addEventListener("change", RequestAccessUpdate);

	row.getElementsByTagName("select")[0].value = access;
}

function RequestChangePassword() {
	if (allowChange) {
		var newPassword = document.getElementById("newPassword").value;

		var dataOutwards = {
			currentPassword: GetPassword(),
			newPassword,
			checklistID: GetChecklistID(),
		};

		$.post(
			"../../Back-End/Checklist/Settings/changePassword.php",
			dataOutwards,
			ChangePasswordReturned
		);

		allowChange = false;
	}
}

function ChangePasswordReturned(data) {
	var json = JSON.parse(data);
	DisplayInfo(json["status"]);

	if (json["status"] === "success") {
		CurrentPasswordError("");
	} else {
		CurrentPasswordError(json["currentPassErrorMsg"]);
	}

	allowChange = true;
}

function RequestRemovePassword() {
	if (allowRemove) {
		var dataOutwards = {
			password: GetPassword(),
			checklistID: GetChecklistID(),
		};

		$.post(
			"../../Back-End/Checklist/Settings/removePassword.php",
			dataOutwards,
			RemovePasswordReturned
		);

		allowRemove = false;
	}
}

function RemovePasswordReturned(data) {
	var json = JSON.parse(data);

	if (json["status"] == "success") {
		document.getElementById("accessRow").remove();
		document.getElementById("currentPasswordRow").remove();
		document.getElementById("newPasswordRow").remove();
		document.getElementById("removePasswordRow").remove();

		AddUnsetPasswordRows();
	} else {
		CurrentPasswordError(json["currentPassErrorMsg"]);
	}

	allowRemove = true;
}

function CurrentPasswordError(errorMsg) {
	var currentPassErrorMsg = document.getElementById("currentPassErrorMsg");
	var currentPass = document.getElementById("currentPassword");

	if (currentPass) {
		currentPassErrorMsg.innerHTML = errorMsg;

		if (errorMsg == "") {
			currentPass.classList.remove("is-invalid");
		} else {
			currentPass.classList.add("is-invalid");
		}
	}
}

function GetPassword() {
	var currPassInput = document.getElementById("currentPassword");

	if (currPassInput) {
		return currPassInput.value;
	} else {
		return "";
	}
}

function GetChecklistID() {
	var fileName = location.pathname.split("/").slice(-1)[0];

	if (fileName.charAt(fileName.length - 4) == ".") {
		fileName = fileName.slice(0, -4);
	}

	return fileName;
}
