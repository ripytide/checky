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

		<!-- Lato font -->
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

		<title>Checky - Register</title>
	</head>
	<body>
		<script src="sharedScripts.js"></script>
		<script src="registerScripts.js"></script>
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

		<div class="main">
			<div class="form-box">
				<form onsubmit="Register();return false">

					<h1>Register</h1>
					
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

					<div class="button-center">
					<button type="submit" class="btn">Signup</button>
					</div>

				</form>
			</div>
		</div>
		
		<?php require("components/footer.html"); ?>

	</body>
</html>
