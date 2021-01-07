<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //retrieve data from post
	$checklistID = $_POST["checklistID"];

    if (true){
        Query("DELETE FROM task WHERE checklistID = ?", "s", $checklistID);

        Query("DELETE FROM checklist WHERE checklistID = ?", "s", $checklistID);

        unlink("../../Front-Facing/checklists/" . $checklistID . ".php");

        $output["status"] = "success";
        $output["checklistID"] = $checklistID;
    }

    echo(json_encode($output));
}
?>