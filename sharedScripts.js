let statusDisplayed = false;
function HandleStatus(json) {
	if (!statusDisplayed) {
		statusDisplayed = true;

		if (json["status"] === "success") {
			$("#statusMsg").text(json["status"]);

			//switch icons
			$("#failIcon").hide();
			$("#successIcon").show();

			//remove error msg
			$("#errorMsg").text("");

			//change color to green
			$("#statusBox").css("backgroundColor", "green");
		} else if (json["status"] === "fail") {
			$("#statusMsg").text(json["status"]);

			//switch icons
			$("#successIcon").hide();
			$("#failIcon").show();

			//add error msg
			$("#errorMsg").text(json["errorMsg"]);

			//change color to red
			$("#statusBox").css("backgroundColor", "red");
		} else {
			console.log("incorrect status given");
		}

		let status = $("#statusBox");

		status.addClass("status-box-active");

		//wait 2s then make the notification fade out
		setTimeout(() => {
			status.removeClass("status-box-active");
			setTimeout(() => { statusDisplayed = false; }, 1000);
		}, 2000);
	}
}