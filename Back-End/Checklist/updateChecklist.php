<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {

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
        Query("UPDATE checklist SET $column = ? WHERE checklistID = ?", "ss", $newValue, $checklistID);

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





