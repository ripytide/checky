<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!-- Hand made style sheet -->
		<link href="../styles.css" rel="stylesheet" />

		<title>Checky - Login</title>
	</head>
	<body>
		<script src="sharedScripts.js"></script>
		<script src="loginScripts.js"></script>
		<script src="navBar.js"></script>

		<?php require("components/navBar.php"); ?>

		<?php require("components/status-box.html"); ?>

		<div class="main">
			<div class="form-box">
				<form onsubmit="Login();return false">

					<h1>Login</h1>
					
					<div class="form-row">
						<label for="username"><i class="fas fa-user"></i><h2>Username:</h2></label>
						<input
							id="username"
							type="username"
							aria-describedby="emailHelp"
						/>
					</div>
					<div class="form-row">
						<span id="userErrorMsg" class="error-msg"></span>
					</div>

					<div class="form-row">
						<label for="password"><i class="fas fa-lock"></i><h2>Password:</h2></label>
						<input
							id="password"
							type="password"
						/>
					</div>

					<div class="form-row">
						<span id="passErrorMsg" class="error-msg"></span>
					</div>

					<div class="form-row form-row-center">
					<button type="submit" class="btn">Login</button>
					</div>

					<div class="form-row form-row-center"><p class="sign-up">Not a user yet? <a href="/register" class="link">Sign up.</a></p></div>

				</form>
			</div>
		</div>
		
		<?php require("components/footer.html"); ?>

	</body>
</html>