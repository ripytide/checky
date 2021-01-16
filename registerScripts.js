function Register() {
	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value;

	let credentials = { username, password };

	$.post(
		"../Back-End/User system/registerHandler.php",
		credentials,
		RegisterReturned
	);
}

function RegisterReturned(data) {
	let output = JSON.parse(data);

	userErrorMsg = document.getElementById("userErrorMsg");
	passErrorMsg = document.getElementById("passErrorMsg");

	userInput = document.getElementById("username");
	passInput = document.getElementById("password");

	if (output["userErrorMsg"] != "") {
		userErrorMsg.innerHTML = output["userErrorMsg"];
		userInput.classList.add("is-invalid");
	} else {
		userInput.classList.remove("is-invalid");
	}

	if (output["passErrorMsg"] != "") {
		passErrorMsg.innerHTML = output["passErrorMsg"];
		passInput.classList.add("is-invalid");
	} else {
		passInput.classList.remove("is-invalid");
	}
}
