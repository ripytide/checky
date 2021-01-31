<?php
session_start();
$loggedIn = isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true);
?>

<header>
	<div class="home">
		<a href="/index">
		<img class="logo" src="/favicon.ico" href="/index">
		</a>
		<a href="/index">Checky</a>
	</div>

	<ul class="norm-nav<?php echo($loggedIn ? " norm-nav-logged-in" : "");?>">
		<?php require("getNavList.php"); ?>
	</ul>

	<button id="navOpen" class="btn btn-hide">Menu</button>
</header>


<ul id="mobileNav" class="mobile-nav">
	<?php require("getNavList.php"); ?>
</ul>
