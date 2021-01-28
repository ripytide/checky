let currentAccess;

function RequestAccessUpdate() {
	let newValue = $("#access").val();

	let dataOutwards = {
		newValue,
		checklistID: GetChecklistID(),
		password: GetPassword(),
	};

	$.post(
		"../../Back-End/Checklist/Settings/updateAccess.php",
		dataOutwards,
		UpdateAccessReturned
	);
}

function UpdateAccessReturned(data) {
	json = JSON.parse(data);

	HandleStatus(json);

	if (json["status"] === "success") {
		currentAccess = json["access"];
	} else {
		CurrentPasswordError(json["currentPassErrorMsg"]);
		$("#access").val(currentAccess);
	}
}

function RequestSetPassword() {
	let password = document.getElementById("setPassword").value;

	let dataOutwards = { password, checklistID: GetChecklistID() };

	$.post(
		"../../Back-End/Checklist/Settings/setPassword.php",
		dataOutwards,
		SetPasswordReturned
	);
}

function SetPasswordReturned(data) {
	let json = JSON.parse(data);

	HandleStatus(json);

	passErrorMsg = document.getElementById("setPassErrorMsg");

	passInput = document.getElementById("setPassword");

	if (json["passErrorMsg"] !== "") {
		passErrorMsg.innerHTML = json["passErrorMsg"];
		passInput.classList.add("is-invalid");
	} else {
		$("#setPasswordRow").hide();

		$("#accessRow").show();
		$("#access").val("Public editable");
		currentAccess = "Public editable";

		$("#currentPassErrorMsg").val("");
		$("#currentPassword").val("");
		$("#currentPassword").removeClass("is-invalid");
		$("#currentPasswordRow").show();

		$("#newPasswordRow").show();
		$("#removePasswordRow").show();
	}
}

function RequestChangePassword() {
	let newPassword = document.getElementById("newPassword").value;

	let dataOutwards = {
		currentPassword: GetPassword(),
		newPassword,
		checklistID: GetChecklistID(),
	};

	$.post(
		"../../Back-End/Checklist/Settings/changePassword.php",
		dataOutwards,
		ChangePasswordReturned
	);
}

function ChangePasswordReturned(data) {
	let json = JSON.parse(data);

	HandleStatus(json);

	if (json["status"] !== "success") {
		CurrentPasswordError(json["currentPassErrorMsg"]);
	}
}

function RequestRemovePassword() {
	let dataOutwards = {
		password: GetPassword(),
		checklistID: GetChecklistID(),
	};

	$.post(
		"../../Back-End/Checklist/Settings/removePassword.php",
		dataOutwards,
		RemovePasswordReturned
	);
}

function RemovePasswordReturned(data) {
	let json = JSON.parse(data);

	HandleStatus(json);

	if (json["status"] == "success") {
		$("#accessRow").hide();
		$("#currentPasswordRow").hide();
		$("#newPasswordRow").hide();
		$("#removePasswordRow").hide();

		$("#setPasswordRow").show();

		AddUnsetPasswordRows();
	} else {
		CurrentPasswordError(json["currentPassErrorMsg"]);
	}
}

function RemovePasswordError() {
	let currentPassErrorMsg = document.getElementById("currentPassErrorMsg");

	currentPassErrorMsg.innerHTML = "";
}

function CurrentPasswordError(errorMsg) {
	let currentPassErrorMsg = document.getElementById("currentPassErrorMsg");
	let currentPass = document.getElementById("currentPassword");

	if (currentPass) {
		currentPassErrorMsg.innerHTML = errorMsg;
	}
}

function GetPassword() {
	let currPassInput = document.getElementById("currentPassword");

	if (currPassInput) {
		return currPassInput.value;
	} else {
		return "";
	}
}

function GetChecklistID() {
	let fileName = location.pathname.split("/").slice(-1)[0];

	if (fileName.charAt(fileName.length - 4) == ".") {
		fileName = fileName.slice(0, -4);
	}

	return fileName;
}
