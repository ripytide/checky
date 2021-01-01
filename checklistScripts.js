$(document).ready(function () {
	GetTasks();
});

function GetTasks() {
	$.post(
		"../../Back-End/Task/getTasks.php",
		{ checklistID: GetChecklistID(), password: GetPassword() },
		GetTasksReturned
	);
}

function GetTasksReturned(data) {
	json = JSON.parse(data);

	if (json["status"] == "success" || json["status"] == "caution") {
		DisplayInfo(json["status"]);

		var table = document
			.getElementById("taskList")
			.getElementsByTagName("tbody")[0];

		var results = json["results"];

		for (var i = 0; i < results.length; i++) {
			var row = table.insertRow();
			row.id = results[i]["taskID"];

			AddTaskCells(row);
			PopulateTaskCells(row, results[i]);
		}
	} else {
		DisplayInfo(json["errorMsg"]);
	}
}

function PopulateTaskCells(row, data) {
	row.cells[0].childNodes[0].checked = data["checkbox"];
	row.cells[1].childNodes[0].value = data["taskTitle"];
	row.cells[2].childNodes[0].value = data["description"];
	row.cells[3].childNodes[0].value = data["priority"];
	row.cells[4].childNodes[0].value = data["status"];
}

function AddTaskCells(row) {
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
	var cell6 = row.insertCell(5);

	cell1.innerHTML = '<input type="checkbox" class="checkbox" />';
	cell1.childNodes[0].addEventListener("change", ChangeCheckbox);

	cell2.innerHTML =
		'<input type="text"class="form-control light-grey"placeholder="title here"/><p class="invalid-feedback"></p>';
	cell2.childNodes[0].addEventListener("change", ChangeTitle);

	cell3.innerHTML =
		'<textarea type="text" class="form-control light-grey" placeholder="description here"></textarea><p class="invalid-feedback"></p>';
	cell3.childNodes[0].addEventListener("change", ChangeDescription);

	cell4.innerHTML =
		'<select class="form-select light-grey" aria-label=".form-select-lg example"><option selected value="None">None</option><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select>';
	cell4.childNodes[0].addEventListener("change", ChangePriority);

	cell5.innerHTML =
		'<select class="form-select light-grey" aria-label=".form-select-lg example"><option selected value="Not started">Not started</option><option value="In progress">In progress</option><option value="Finished">Finished</option></select>';
	cell5.childNodes[0].addEventListener("change", ChangeStatus);

	cell6.innerHTML =
		'<button type="button" class="btn btn-secondary">Delete</button>';
	cell6.childNodes[0].addEventListener("click", RequestDelete);
}

function NewTask() {
	$.post(
		"../../Back-End/Task/newTask.php",
		{ checklistID: GetChecklistID(), password: GetPassword() },
		AddTaskReturned
	);
}

function AddTaskReturned(data) {
	json = JSON.parse(data);

	if (json["status"] == "success") {
		DisplayInfo("success");

		var table = document
			.getElementById("taskList")
			.getElementsByTagName("tbody")[0];

		var row = table.insertRow(-1);

		row.id = json["taskID"];

		AddTaskCells(row);
	} else {
		DisplayInfo(json["errorMsg"]);
	}
}

function RequestDelete() {
	var taskID = this.parentElement.parentElement.id;

	var dataOutwards = {
		taskID,
		checklistID: GetChecklistID(),
		password: GetPassword(),
	};

	$.post("../../Back-End/Task/deleteTask.php", dataOutwards, DeleteReturned);
}

function DeleteReturned(data) {
	var json = JSON.parse(data);

	if (json["status"] === "success") {
		var row = document.getElementById(json["taskID"]);
		row.remove();
	} else {
		DisplayInfo(json["errorMsg"]);
	}
}

function ChangeCheckbox() {
	//sets 1 if checked and 0 if not.
	var newValue = 0;

	if (this.checked) newValue = 1;

	RequestUpdate(this, "checkbox", newValue);
}
function ChangeTitle() {
	var newValue = this.value;
	RequestUpdate(this, "taskTitle", newValue);
}
function ChangeDescription() {
	var newValue = this.value;
	RequestUpdate(this, "description", newValue);
}
function ChangePriority() {
	var newValue = this.value;
	RequestUpdate(this, "priority", newValue);
}
function ChangeStatus() {
	var newValue = this.value;
	RequestUpdate(this, "status", newValue);
}

function RequestUpdate(node, column, newValue) {
	var taskID = node.parentElement.parentElement.id;

	var dataOutwards = {
		taskID,
		column,
		newValue,
		checklistID: GetChecklistID(),
		password: GetPassword(),
	};

	$.post(
		"../../Back-End/Task/updateTask.php",
		dataOutwards,
		UpdateChecklistReturned
	);
}

function UpdateChecklistReturned(data) {
	var json = JSON.parse(data);

	DisplayInfo(json["status"]);
	if (json["column"] == "taskTitle") {
		var taskID = json["taskID"];
		var row = document.getElementById(taskID);
		var input = row.cells[1].childNodes[0];
		var errorMsg = row.cells[1].childNodes[1];

		if (json["status"] != "success") {
			input.classList.add("is-invalid");
			errorMsg.innerText = json["errorMsg"];
		} else {
			input.classList.remove("is-invalid");
			errorMsg.innerText = "";
		}
	}
	if (json["column"] == "description") {
		var taskID = json["taskID"];
		var row = document.getElementById(taskID);
		var input = row.cells[2].childNodes[0];
		var errorMsg = row.cells[2].childNodes[1];

		if (json["status"] != "success") {
			input.classList.add("is-invalid");
			errorMsg.innerText = json["errorMsg"];
		} else {
			input.classList.remove("is-invalid");
			errorMsg.innerText = "";
		}
	}
}

var sortDirection = {
	checkbox: true,
	title: true,
	description: true,
	priority: true,
	status: true,
};

function SortChecklist(column) {
	//bubble sort
	var table = document
		.getElementById("taskList")
		.getElementsByTagName("tbody")[0];
	var rows = table.rows;
	var loop = true;

	while (loop) {
		loop = false;

		for (var i = 0; i < rows.length - 1; i++) {
			//start at 1 to ignore the title row
			if (sortDirection[column]) {
				if (CompareRows(rows[i], rows[i + 1], column)) {
					SwapRows(rows[i], rows[i + 1]);
					loop = true;
				}
			} else {
				if (CompareRows(rows[i + 1], rows[i], column)) {
					SwapRows(rows[i], rows[i + 1]);
					loop = true;
				}
			}
		}
	}

	sortDirection[column] = !sortDirection[column];
}

function CompareRows(row1, row2, column) {
	//is the first row larger than the second in that column?
	switch (column) {
		case "checkbox":
			return (
				row1.getElementsByTagName("input")[0].checked >
				row2.getElementsByTagName("input")[0].checked
			);
		case "title":
			return (
				row1.getElementsByTagName("input")[1].value.toLowerCase() >
				row2.getElementsByTagName("input")[1].value.toLowerCase()
			);
		case "description":
			return (
				row1.getElementsByTagName("textarea")[0].value.toLowerCase() >
				row2.getElementsByTagName("textarea")[0].value.toLowerCase()
			);
		case "priority":
			var row1Priority = row1.getElementsByTagName("select")[0].value;
			var row2Priority = row2.getElementsByTagName("select")[0].value;

			return GetPriorityAsInt(row1Priority) > GetPriorityAsInt(row2Priority);
		case "status":
			var row1Status = row1.getElementsByTagName("select")[1].value;
			var row2Status = row2.getElementsByTagName("select")[1].value;

			return GetStatusAsInt(row1Status) > GetStatusAsInt(row2Status);
	}
}

function GetPriorityAsInt(value) {
	switch (value) {
		case "None":
			return 0;
		case "Low":
			return 1;
		case "Medium":
			return 2;
		case "High":
			return 3;
	}
}
function GetStatusAsInt(value) {
	switch (value) {
		case "Not started":
			return 0;
		case "In progress":
			return 1;
		case "Finished":
			return 2;
	}
}

function SwapRows(row1, row2) {
	var tempCheckbox,
		tempTitle,
		tempDescription,
		tempPriority,
		tempStatus,
		tempID;

	tempCheckbox = row1.getElementsByTagName("input")[0].checked;
	tempTitle = row1.getElementsByTagName("input")[1].value;
	tempDescription = row1.getElementsByTagName("textarea")[0].value;
	tempPriority = row1.getElementsByTagName("select")[0].value;
	tempStatus = row1.getElementsByTagName("select")[1].value;
	tempID = row1.id;

	row1.getElementsByTagName("input")[0].checked = row2.getElementsByTagName(
		"input"
	)[0].checked;
	row1.getElementsByTagName("input")[1].value = row2.getElementsByTagName(
		"input"
	)[1].value;
	row1.getElementsByTagName("textarea")[0].value = row2.getElementsByTagName(
		"textarea"
	)[0].value;
	row1.getElementsByTagName("select")[0].value = row2.getElementsByTagName(
		"select"
	)[0].value;
	row1.getElementsByTagName("select")[1].value = row2.getElementsByTagName(
		"select"
	)[1].value;
	row1.id = row2.id;

	row2.getElementsByTagName("input")[0].checked = tempCheckbox;
	row2.getElementsByTagName("input")[1].value = tempTitle;
	row2.getElementsByTagName("textarea")[0].value = tempDescription;
	row2.getElementsByTagName("select")[0].value = tempPriority;
	row2.getElementsByTagName("select")[1].value = tempStatus;
	row2.id = tempID;
}

function GetChecklistID() {
	var fileName = location.pathname.split("/").slice(-1)[0];

	if (fileName.charAt(fileName.length - 4) == ".") {
		fileName = fileName.slice(0, -4);
	}

	return fileName;
}

function GetPassword() {
	var currPassInput = document.getElementById("currentPassword");

	if (currPassInput) {
		return currPassInput.value;
	} else {
		return "";
	}
}

function DisplayInfo(data) {
	var notify = document.getElementById("notify");

	notify.innerHTML = data;
}