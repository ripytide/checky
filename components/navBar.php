<?php
session_start();
$loggedIn = isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true);
?>
<header>
	<div class="home"><img class="logo" src="/favicon.ico" href="/index"><a href="/index">Checky</></div>

	<ul class="normNav">
		<?php require("getNavList.php"); ?>
	</ul>

	<button id="navOpen" class="btn btn-hide">Menu</button>
</header>

<div id="overlay" class="overlay">
	<ul class="mobileNav">
		<?php require("getNavList.php"); ?>
	</ul>
</div>