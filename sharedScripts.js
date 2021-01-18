var statusDisplayed = false;
function HandleStatus(json) {
	if (!statusDisplayed) {
		statusDisplayed = true;

		$("#statusMsg").text(json["status"]);

		if (json["status"] === "success") {
			//switch icons
			$("#failIcon").hide();
			$("#successIcon").show();
			//remove error msg
			$("#errorMsg").text("");

			//toggle css as their is no error msg
			$("#statusLine").removeClass("failLine");
			$("#statusLine").addClass("successLine");

			//change color to green
			$("#statusBox").css("backgroundColor", "green");
		} else if (json["status"] === "fail") {
			//switch icone
			$("#successIcon").hide();
			$("#failIcon").show();

			//add error msg
			$("#errorMsg").text(json["errorMsg"]);

			//toggle css for space for error msg
			$("#statusLine").removeClass("successLine");
			$("#statusLine").addClass("failLine");

			//change color to red
			$("#statusBox").css("backgroundColor", "red");
		} else {
			console.log("incorrect status given");
		}

		var status = $("#statusBox");

		//reset status div
		status.css({ top: "0px", opacity: 0 });

		status.show();
		status.animate({
			top: "75px",
			opacity: 1,
		});

		//wait 1.8s then make the notification fade out
		setTimeout(() => {
			status.fadeOut();
			statusDisplayed = false;
		}, 1800);
	}
}
