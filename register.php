<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<link href="style.css" rel="stylesheet" />

		<title>Checky - Register</title>
	</head>
	<body>
		<script src="sharedScripts.js"></script>
		<script src="registerScripts.js"></script>

		<?php require("getNavBar.php"); ?>

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
					<h1>Register</h1>
					<form onsubmit="Register();return false">
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
									Signup
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<p id="result"></p>

		<footer>
			<div>
				<span>Copyright© 2020, James Forster, All rights reserved</span>
			</div>
		</footer>

	</body>
</html>
