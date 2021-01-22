$(document).ready(function () {
	let menu = $("#mobileNav");
	let navOpen = document.getElementById("navOpen");

	navOpen.addEventListener("click", () => {
		menu.toggleClass("menuActive");
	});
});
