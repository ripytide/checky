<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //requires connection to database
    require("../connect.php");

    //retrieve data from post
	$checklistID = $_POST["checklistID"];

    if (true){

        //prepare, bind and execute the statement
        $stmt = $conn->prepare("DELETE FROM checklist WHERE checklistID = ?");
        $stmt->bind_param("s", $checklistID);
        $stmt->execute();
        
        //prepare, bind and execute the statement
        $stmt = $conn->prepare("DELETE FROM task WHERE checklistID = ?");
        $stmt->bind_param("s", $checklistID);
        $stmt->execute();

        //close connection
        $stmt->close();
        $conn->close();

        unlink("../../Front-Facing/checklists/" . $checklistID . ".php");

        

        $output["status"] = "success";
        $output["checklistID"] = $checklistID;
    }

    echo(json_encode($output));
}
?>