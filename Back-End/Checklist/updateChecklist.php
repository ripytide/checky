<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

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

    $checklistUsername = GetUsername($checklistID);

    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }

    if ($valid and ($loggedin and $username === $checklistUsername)){
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





