function Login() {
	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value;

	let credentials = { username, password };

	$.post(
		"../Back-End/User system/loginHandler.php",
		credentials,
		LoginReturned,
		"json"
	);
}

function LoginReturned(json) {
	HandleStatus(json);

	if (json["status"] === "success") {
		window.location.href = "index";
	} else {
		userErrorMsg = document.getElementById("userErrorMsg");
		passErrorMsg = document.getElementById("passErrorMsg");

		userInput = document.getElementById("username");
		passInput = document.getElementById("password");

		if (json["userErrorMsg"] != "") {
			userErrorMsg.innerHTML = json["userErrorMsg"];
			userInput.classList.add("is-invalid");
		} else {
			userInput.classList.remove("is-invalid");
		}

		if (json["passErrorMsg"] != "") {
			passErrorMsg.innerHTML = json["passErrorMsg"];
			passInput.classList.add("is-invalid");
		} else {
			passInput.classList.remove("is-invalid");
		}
	}
}
