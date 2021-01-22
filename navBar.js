let menuOpen = false;

$(document).ready(function () {
	let navOpen = document.getElementById("navOpen");
	navOpen.addEventListener("click", ToggleMenu);
	window.addEventListener("resize", CheckToggleMenu);
});

function ToggleMenu() {
	let menu = $("#mobileNav");

	if (!menuOpen) {
		menu.height(menu.children().length * menu.children(":first").outerHeight());
	} else {
		menu.height(0);
	}

	menuOpen = !menuOpen;
}

function CheckToggleMenu() {
	let bool = window.matchMedia("(max-width: 900px)").matches;
	if (!bool) {
		if (menuOpen) {
			ToggleMenu();
		}
	}
}
