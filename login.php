<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<link href="styles.css" rel="stylesheet" />
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

		<title>Checky - Login</title>
	</head>

	<body>
		<script src="sharedScripts.js"></script>
		<script src="loginScripts.js"></script>
		<script src="navBar.js"></script>

		<?php require("components/navBar.php"); ?>

		<div class="statusBox">
			<div id="statusLine">
				<i class="fas fa-check-circle icon fa-2x" id="successIcon"></i>
				<i class="far fa-times-circle icon fa-2x" id="failIcon"></i>
				<h1 id="statusMsg"></h1>
			</div>
			<div id="errorMsgLine">
				<p id="errorMsg"></p>
			</div>	
		</div>

		<div>
			<div>
				<div class="login-box">
					<h1>Login</h1>
					<form onsubmit="Login();return false">
						<div>
							<label for="username">username</label>
							<input
								id="username"
								type="username"
								aria-describedby="emailHelp"
							/>
							<p id="userErrorMsg"></p>
						</div>
						<div>
							<label for="password">Password</label>
							<input
								id="password"
								type="password"
							/>
							<p id="passErrorMsg"></p>
							<div>
								<button
									type="submit"
								>
									Login
								</button>
							</div>
						</div>
					</form>
					<p>
						Don't have an account yet? <a>Sign up.</a>
					</p>
				</div>
			</div>
		</div>

		<?php require("components/footer.html"); ?>

	</body>
</html>
