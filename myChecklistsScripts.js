$(document).ready(function () {
	GetChecklists();
});

function GetChecklists() {
	$.post("../Back-End/Checklist/getChecklists.php", {}, ShowChecklists);
}

function ShowChecklists(data) {
	json = JSON.parse(data);

	if (json["status"] == "success" || json["status"] == "caution") {
		DisplayInfo(json["status"]);

		var table = document
			.getElementById("checklistList")
			.getElementsByTagName("tbody")[0];

		var results = json["results"];

		for (var i = 0; i < results.length; i++) {
			var row = table.insertRow(-1);
			row.id = results[i]["checklistID"];

			AddChecklistCells(row, results[i]["checklistID"]);
			row.cells[0].childNodes[0].value = results[i]["checklistTitle"];
		}
	} else {
		DisplayInfo("Fail");
	}
}

function NewChecklist() {
	$.post("../Back-End/Checklist/newChecklist.php", {}, AddChecklistRow);
}

function AddChecklistRow(data) {
	json = JSON.parse(data);

	if (json["status"] == "success") {
		DisplayInfo("success");

		var table = document
			.getElementById("checklistList")
			.getElementsByTagName("tbody")[0];

		var row = table.insertRow(-1);

		row.id = json["checklistID"];

		AddChecklistCells(row, json["checklistID"]);
	} else {
		DisplayInfo("Fail");
	}
}

function AddChecklistCells(row, checklistID) {
	//TODO - add link to view button
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);

	cell1.innerHTML =
		'<input type="text"class="form-control light-grey"placeholder="title here"/><p class="invalid-feedback"></p>';
	cell1.childNodes[0].addEventListener("change", ChangeTitle);

	cell2.innerHTML = '<a class="btn btn-secondary">Visit</a>';
	cell2.childNodes[0].href = "checklists/".concat(checklistID);

	cell3.innerHTML =
		'<button type="button" class="btn btn-secondary">Delete</button>';
	cell3.childNodes[0].addEventListener("click", RequestDelete);
}

function RequestDelete() {
	var checklistID = this.parentElement.parentElement.id;

	var dataOutwards = { checklistID };

	$.post(
		"../Back-End/Checklist/deleteChecklist.php",
		dataOutwards,
		DeleteReturned
	);
}

function DeleteReturned(data) {
	var json = JSON.parse(data);

	DisplayInfo(json["status"]);

	var row = document.getElementById(json["checklistID"]);

	row.remove();
}

function ChangeTitle() {
	var newValue = this.value;
	RequestUpdate(this, "checklistTitle", newValue);
}

function RequestUpdate(node, column, newValue) {
	var checklistID = node.parentElement.parentElement.id;

	var dataOutwards = { checklistID, column, newValue };

	$.post(
		"../Back-End/Checklist/updateChecklist.php",
		dataOutwards,
		UpdateReturned
	);
}

function UpdateReturned(data) {
	var json = JSON.parse(data);

	DisplayInfo(json["status"]);

	if (json["column"] == "checklistTitle") {
		var checklistID = json["checklistID"];
		var row = document.getElementById(checklistID);
		var input = row.cells[0].childNodes[0];
		var errorMsg = row.cells[0].childNodes[1];

		if (json["status"] != "success") {
			input.classList.add("is-invalid");
			errorMsg.innerText = json["errorMsg"];
		} else {
			input.classList.remove("is-invalid");
			errorMsg.innerText = "";
		}
	}
}

function DisplayInfo(data) {
	var notify = document.getElementById("notify");

	notify.innerHTML = data;
}
