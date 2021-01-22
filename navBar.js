$(document).ready(function () {
	let overlay = $("#overlay");
	let navOpen = document.getElementById("navOpen");

	navOpen.addEventListener("click", () => {
		overlay.toggleClass("overlayActive");
	});
});
