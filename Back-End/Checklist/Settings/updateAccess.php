<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //get data from post
	$checklistID = $_POST["checklistID"];
    $newValue = $_POST["newValue"];
    $givenPassword = $_POST["password"];

    $hash = GetHash($checklistID);
    $checklistUsername = GetUsername($checklistID);

    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }
    
    if (((password_verify($givenPassword, $hash)) and ($hash)) or ($loggedin and $username === $checklistUsername)){

        Query("UPDATE checklists SET access = ? WHERE checklistID = ?", "ss", $newValue, $checklistID);

        $output["status"] = "success";

    } else if ($checklistUsername){
        $output["status"] = "fail";
        $output["errorMsg"] = "You cannot change this as this is not your checklist";
    } else{
        $output["status"] = "fail";
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