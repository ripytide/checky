<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //requires connection to database
    require("../connect.php");

    //retrieve data from post
	$checklistID = $_POST["checklistID"];
    $column = $_POST["column"];
    $newValue = $_POST["newValue"];

    $valid = true;

    if ($column === "checklistTitle") {
        $errorMsg = IsValidChecklistTitle($newValue);
        if ($errorMsg === ""){
        } else{
            $valid = false;

            

            $output["status"] = "fail";
            $output["checklistID"] = $checklistID;
            $output["column"] = $column;
            $output["errorMsg"] = $errorMsg;

        }
    }else{
        $valid = false;

        

        $output["status"] = "fail";
        $output["checklistID"] = $checklistID;
    }

    if ($valid){
        //prepare, bind and execute the statement depending on which column needed.
        $stmt = $conn->prepare("UPDATE checklist SET $column = ? WHERE checklistID = ?");
        $stmt->bind_param("ss", $newValue, $checklistID);
        $stmt->execute();

        //close connection
        $stmt->close();
        $conn->close();

        

        $output["status"] = "success";
        $output["checklistID"] = $checklistID;
        $output["column"] = $column;
    }

    echo(json_encode($output));
}

function IsValidChecklistTitle($title)
{
    if (mb_strlen($title) <= 16){
        return("");
    } else{
        return("This Title is too long");
    }
}

?>





