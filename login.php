<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Bootstrap CSS -->
		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
			crossorigin="anonymous"
		/>

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<link href="style.css" rel="stylesheet" />

		<title>Checky - Login</title>
	</head>

	<body>
		<script src="sharedScripts.js"></script>
		<script src="loginScripts.js"></script>

		<?php require("getNavBar.php"); ?>

		<div id="statusBox">
			<div id="statusLine" class="flexCenter">
				<i class="fas fa-check-circle icon fa-2x" id="successIcon"></i>
				<i class="far fa-times-circle icon fa-2x" id="failIcon"></i>
				<h1 id="statusMsg" class="align-middle"></h1>
			</div>
			<div id="errorMsgLine" class="flexCenter">
				<p id="errorMsg"></p>
			</div>	
		</div>

		<div class="container" style="margin-top: 10%">
			<div class="row justify-content-center">
				<div class="login-box border border-4 border-dark rounded px-3 pt-3">
					<h1 class="mb-3 text-center text-decoration-underline">Login</h1>
					<form class="has-validation" onsubmit="Login();return false">
						<div class="mb-3">
							<label for="username" class="form-label">username</label>
							<input
								id="username"
								type="username"
								class="light-grey form-control border border-4 border-dark"
								aria-describedby="emailHelp"
							/>
							<p id="userErrorMsg" class="invalid-feedback"></p>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<input
								id="password"
								type="password"
								class="light-grey form-control border border-4 border-dark"
							/>
							<p id="passErrorMsg" class="invalid-feedback"></p>
							<div class="text-center m-2">
								<button
									type="submit"
									class="btn btn-primary text-center"
								>
									Login
								</button>
							</div>
						</div>
					</form>
					<p class="my-2">
						Don't have an account yet? <a class="link-primary">Sign up.</a>
					</p>
				</div>
			</div>
		</div>

		<footer>
			<div class="container text-center p-3">
				<span>Copyright© 2020, James Forster, All rights reserved</span>
			</div>
		</footer>

		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
			crossorigin="anonymous"
		></script>
	</body>
</html>
