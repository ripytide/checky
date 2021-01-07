<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //get data from post
	$checklistID = $_POST["checklistID"];
    $column = $_POST["column"];
    $newValue = $_POST["newValue"];
    $givenPassword = $_POST["password"];

    $actualPassword = GetPassword($checklistID);
    $checklistUsername = GetUsername($checklistID);

    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }
    
    if ((($givenPassword === $actualPassword) and ($actualPassword !== null)) or ($loggedin and $username === $checklistUsername)){
        if (in_array($column, array("access"))){
            Query("UPDATE checklist SET $column = ? WHERE checklistID = ?", "ss", $newValue, $checklistID);

            $output["status"] = "success";
            $output["column"] = $column;
            $output["access"] = $newValue;
        } else{
            $output["status"] = "fail";
            $output["column"] = $column;
        }
    } else if ($checklistUsername){
        $output["status"] = "fail";
        $output["column"] = $column;
        $output["errorMsg"] = "You cannot change this as this is not you checklist";
    } else{
        $output["status"] = "fail";
        $output["column"] = $column;
        $output["currentPassErrorMsg"] = "This password is incorrect";
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