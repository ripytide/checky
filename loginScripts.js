function Login() {
	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value;

	let credentials = { username, password };

	$.post(
		"../Back-End/User system/loginHandler.php",
		credentials,
		LoginReturned
	);
}

function LoginReturned(data) {
	let output = JSON.parse(data);

	userErrorMsg = document.getElementById("userErrorMsg");
	passErrorMsg = document.getElementById("passErrorMsg");

	userInput = document.getElementById("username");
	passInput = document.getElementById("password");

	if (output["status"] == "success") {
		window.location.href = "index";

		return;
	}

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
