$(document).ready(function () {
	GrabChecklist();
});

function GrabChecklist() {
	$.post(
		"../../Back-End/Task/grabChecklist.php",
		{ checklistID: GetChecklistID(), password: "" },
		GrabChecklistReturned,
		"json"
	);
}

function GrabChecklistReturned(json) {
	HandleStatus(json);

	if (json["tasksAccess"]) {
		$("#taskListDiv").show();
		ShowChecklist(json["tasks"]);
		$("#checklistTitle").val(json["checklistTitle"]);

		//handles readonly
		if (
			(json["access"] === "Public not editable" && !json["userChecklist"]) ||
			(json["access"] === "Public not editable" &&
				json["settingsAccess"] === false) //settings access only false for non authentic user checklist request
		) {
			$("#editButton").show();
			SetReadOnly(true);
		}
	} else if (!json["userChecklist"]) {
		$("#authenticationBox").show();
	}

	if (json["settingsAccess"]) {
		$("#managementBox").show();

		if (json["userChecklist"]) {
			$("#accessRow").show();
			$("#access").val(json["access"]);
			currentAccess = json["access"];
		} else {
			if (json["passwordSet"]) {
				$("#accessRow").show();
				$("#access").val(json["access"]);
				currentAccess = json["access"];

				$("#currentPasswordRow").show();
				$("#newPasswordRow").show();
				$("#removePasswordRow").show();
			} else {
				$("#setPasswordRow").show();
			}
		}
	}
}

function ReGrabChecklist() {
	$.post(
		"../../Back-End/Task/grabChecklist.php",
		{ checklistID: GetChecklistID(), password: $("#authPassword").val() },
		ReGrabChecklistReturned,
		"json"
	);
}

function ReGrabChecklistReturned(json) {
	//only called for non user checklists
	HandleStatus(json);

	if (json["tasksAccess"]) {
		//if task is given access so is settings access given
		//tasks stuff
		$("#authenticationBox").hide();

		$("#taskListDiv").show();
		ShowChecklist(json["tasks"]);
		$("#checklistTitle").val(json["checklistTitle"]);

		//setting stuff
		$("#managementBox").show();

		if (json["passwordSet"]) {
			$("#accessRow").show();
			$("#access").val(json["access"]);
			currentAccess = json["access"];

			$("#currentPasswordRow").show();
			$("#newPasswordRow").show();
			$("#removePasswordRow").show();
		} else {
			$("#setPasswordRow").show();
		}
	} else {
		$("#authPassword").addClass("is-invalid");
		$("#authPassErrorMsg").text(json["errorMsg"]);
	}
}

function RequestReadAccess() {
	$.post(
		"../../Back-End/Task/readAccess.php",
		{ checklistID: GetChecklistID(), password: GetPassword() },
		ReadAccessReturned,
		"json"
	);
}

function ReadAccessReturned(json) {
	HandleStatus(json);

	if (json["status"] === "success") {
		SetReadOnly(false);
		$("#editButton").remove();
	} else {
		CurrentPasswordError(json["errorMsg"]);
	}
}

function SetReadOnly(bool) {
	let table = document
		.getElementById("taskList")
		.getElementsByTagName("tbody")[0];
	let rows = table.rows;

	for (let i = 0; i < rows.length; i++) {
		rows[i].cells[0].childNodes[0].disabled = bool;
		rows[i].cells[1].childNodes[0].readOnly = bool;
		rows[i].cells[2].childNodes[0].readOnly = bool;
		rows[i].cells[3].childNodes[0].disabled = bool;
		rows[i].cells[4].childNodes[0].disabled = bool;
		document.getElementById("checklistTitle").contentEditable = bool;
	}
}

function ShowChecklist(tasks) {
	let table = document
		.getElementById("taskList")
		.getElementsByTagName("tbody")[0];

	if (tasks) {
		for (let i = 0; i < tasks.length; i++) {
			let row = table.insertRow();
			row.id = tasks[i]["taskID"];

			AddTaskCells(row);
			PopulateTaskCells(row, tasks[i]);
		}
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
	let cell1 = row.insertCell(0);
	let cell2 = row.insertCell(1);
	let cell3 = row.insertCell(2);
	cell3.classList.add("non-important-cell")
	let cell4 = row.insertCell(3);
	cell4.classList.add("non-important-cell");
	let cell5 = row.insertCell(4);
	cell5.classList.add("non-important-cell");
	let cell6 = row.insertCell(5);


	cell1.innerHTML = '<input type="checkbox"/>';
	cell1.childNodes[0].addEventListener("change", ChangeCheckbox);

	cell2.innerHTML =
		'<input type="text" placeholder="title here"/><p class="error-msg"></p>';
	cell2.childNodes[0].addEventListener("change", ChangeTitle);

	cell3.innerHTML =
		'<textarea type="text" placeholder="description here"></textarea><p class="error-msg"></p>';
	cell3.childNodes[0].addEventListener("change", ChangeDescription);

	cell4.innerHTML =
		'<select><option selected value="None">None</option><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select>';
	cell4.childNodes[0].addEventListener("change", ChangePriority);

	cell5.innerHTML =
		'<select><option selected value="Not started">Not started</option><option value="In progress">In progress</option><option value="Finished">Finished</option></select>';
	cell5.childNodes[0].addEventListener("change", ChangeStatus);

	cell6.innerHTML = '<button type="button" class="btn">Delete</button>';
	cell6.childNodes[0].addEventListener("click", RequestDelete);
}

function NewTask() {
	$.post(
		"../../Back-End/Task/newTask.php",
		{ checklistID: GetChecklistID(), password: GetPassword() },
		NewTaskReturned,
		"json"
	);
}

function NewTaskReturned(json) {
	HandleStatus(json);

	if (json["status"] === "success") {
		let table = document
			.getElementById("taskList")
			.getElementsByTagName("tbody")[0];

		let row = table.insertRow(-1);

		row.id = json["taskID"];

		AddTaskCells(row);
	} else if (!json["userChecklist"]) {
		CurrentPasswordError(json["errorMsg"]);
	}
}

function RequestDelete() {
	let taskID = this.parentElement.parentElement.id;

	let dataOutwards = {
		taskID,
		checklistID: GetChecklistID(),
		password: GetPassword(),
	};

	$.post(
		"../../Back-End/Task/deleteTask.php",
		dataOutwards,
		DeleteReturned,
		"json"
	);
}

function DeleteReturned(json) {
	HandleStatus(json);

	if (json["status"] === "success") {
		let row = document.getElementById(json["taskID"]);
		row.remove();
	} else if (!json["userChecklist"]) {
		CurrentPasswordError(json["errorMsg"]);
	}
}

function ChangeChecklistTitle() {
	let dataOutwards = {
		newValue: $("#checklistTitle").val(),
		column: "checklistTitle",
		checklistID: GetChecklistID(),
		password: GetPassword(),
	};

	$.post(
		"../Back-End/Checklist/updateChecklist.php",
		dataOutwards,
		UpdateChecklistTitleReturned,
		"json"
	);
}

function UpdateChecklistTitleReturned(json) {
	HandleStatus(json);

	if (json["status"] !== "success") {
		CurrentPasswordError(json["errorMsg"]);
	}
}

function ChangeCheckbox() {
	//sets 1 if checked and 0 if not.
	let newValue = 0;

	if (this.checked) newValue = 1;

	RequestUpdateCell(this, "checkbox", newValue);
}
function ChangeTitle() {
	let newValue = this.value;
	RequestUpdateCell(this, "taskTitle", newValue);
}
function ChangeDescription() {
	let newValue = this.value;
	RequestUpdateCell(this, "description", newValue);
}
function ChangePriority() {
	let newValue = this.value;
	RequestUpdateCell(this, "priority", newValue);
}
function ChangeStatus() {
	let newValue = this.value;
	RequestUpdateCell(this, "status", newValue);
}

function RequestUpdateCell(node, column, newValue) {
	let taskID = node.parentElement.parentElement.id;

	let dataOutwards = {
		taskID,
		column,
		newValue,
		checklistID: GetChecklistID(),
		password: GetPassword(),
	};

	$.post(
		"../../Back-End/Task/updateTask.php",
		dataOutwards,
		UpdateChecklistReturned,
		"json"
	);
}

function UpdateChecklistReturned(json) {
	HandleStatus(json);

	if (json["column"] === "taskTitle") {
		let taskID = json["taskID"];
		let row = document.getElementById(taskID);
		let input = row.cells[1].childNodes[0];
		let errorMsg = row.cells[1].childNodes[1];

		if (json["status"] !== "success") {
			input.classList.add("is-invalid");
			errorMsg.innerText = json["errorMsg"];
		} else {
			input.classList.remove("is-invalid");
			errorMsg.innerText = "";
		}
	} else if (json["column"] === "description") {
		let taskID = json["taskID"];
		let row = document.getElementById(taskID);
		let input = row.cells[2].childNodes[0];
		let errorMsg = row.cells[2].childNodes[1];

		if (json["status"] !== "success") {
			input.classList.add("is-invalid");
			errorMsg.innerText = json["errorMsg"];
		} else {
			input.classList.remove("is-invalid");
			errorMsg.innerText = "";
		}
	} else if (!json["userChecklist"] && json["status"] == !"success") {
		CurrentPasswordError(json["errorMsg"]);
	}
}

let sortDirection = {
	checkbox: true,
	title: true,
	description: true,
	priority: true,
	status: true,
};

function SortChecklist(column) {
	//bubble sort
	let table = document
		.getElementById("taskList")
		.getElementsByTagName("tbody")[0];
	let rows = table.rows;
	let loop = true;

	while (loop) {
		loop = false;

		for (let i = 0; i < rows.length - 1; i++) {
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
			let row1Priority = row1.getElementsByTagName("select")[0].value;
			let row2Priority = row2.getElementsByTagName("select")[0].value;

			return GetPriorityAsInt(row1Priority) > GetPriorityAsInt(row2Priority);
		case "status":
			let row1Status = row1.getElementsByTagName("select")[1].value;
			let row2Status = row2.getElementsByTagName("select")[1].value;

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
	let tempCheckbox,
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
	let fileName = location.pathname.split("/").slice(-1)[0];

	if (fileName.charAt(fileName.length - 4) == ".") {
		fileName = fileName.slice(0, -4);
	}

	return fileName;
}

function GetPassword() {
	let currPassInput = document.getElementById("currentPassword");

	if (currPassInput) {
		return currPassInput.value;
	} else {
		return "";
	}
}
