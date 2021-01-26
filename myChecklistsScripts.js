$(document).ready(function () {
	GetChecklists();
});

function GetChecklists() {
	$.post("../Back-End/Checklist/getChecklists.php", {}, ShowChecklists);
}

function ShowChecklists(data) {
	json = JSON.parse(data);

	HandleStatus(json);

	if (json["status"] == "success") {
		let table = document
			.getElementById("checklistList")
			.getElementsByTagName("tbody")[0];

		let results = json["results"];

		for (let i = 0; i < results.length; i++) {
			let row = table.insertRow(-1);
			row.id = results[i]["checklistID"];

			AddChecklistCells(row, results[i]["checklistID"]);
			row.cells[0].childNodes[0].value = results[i]["checklistTitle"];
		}
	}
}

function NewChecklist() {
	$.post("../Back-End/Checklist/newChecklist.php", {}, AddChecklistRow);
}

function AddChecklistRow(data) {
	json = JSON.parse(data);

	HandleStatus(json);

	if (json["status"] == "success") {
		let table = document
			.getElementById("checklistList")
			.getElementsByTagName("tbody")[0];

		let row = table.insertRow(-1);

		row.id = json["checklistID"];

		AddChecklistCells(row, json["checklistID"]);
	}
}

function AddChecklistCells(row, checklistID) {
	//TODO - add link to view button
	let cell1 = row.insertCell(0);
	let cell2 = row.insertCell(1);
	let cell3 = row.insertCell(2);

	cell1.innerHTML =
		'<input type="text" placeholder="title here"/><p class="error-msg"></p>';
	cell1.childNodes[0].addEventListener("change", ChangeTitle);

	cell2.innerHTML = '<a class="btn">Visit</a>';
	cell2.childNodes[0].href = "checklists/".concat(checklistID);

	cell3.innerHTML =
		'<button type="button" class="btn">Delete</button>';
	cell3.childNodes[0].addEventListener("click", RequestDelete);
}

function RequestDelete() {
	let checklistID = this.parentElement.parentElement.id;

	let dataOutwards = { checklistID };

	$.post(
		"../Back-End/Checklist/deleteChecklist.php",
		dataOutwards,
		DeleteReturned
	);
}

function DeleteReturned(data) {
	let json = JSON.parse(data);

	HandleStatus(json);

	let row = document.getElementById(json["checklistID"]);

	row.remove();
}

function ChangeTitle() {
	let newValue = this.value;
	RequestUpdate(this, "checklistTitle", newValue);
}

function RequestUpdate(node, column, newValue) {
	let checklistID = node.parentElement.parentElement.id;

	let dataOutwards = { checklistID, column, newValue };

	$.post(
		"../Back-End/Checklist/updateChecklist.php",
		dataOutwards,
		UpdateReturned
	);
}

function UpdateReturned(data) {
	let json = JSON.parse(data);

	HandleStatus(json);

	if (json["column"] == "checklistTitle") {
		let checklistID = json["checklistID"];
		let row = document.getElementById(checklistID);
		let input = row.cells[0].childNodes[0];
		let errorMsg = row.cells[0].childNodes[1];

		if (json["status"] != "success") {
			input.classList.add("is-invalid");
			errorMsg.innerText = json["errorMsg"];
		} else {
			input.classList.remove("is-invalid");
			errorMsg.innerText = "";
		}
	}
}
