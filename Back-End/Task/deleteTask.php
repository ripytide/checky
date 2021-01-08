<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //retrieve data from post
    $taskID = $_POST["taskID"];
    $checklistID = $_POST["checklistID"];
    $givenPassword = $_POST["password"];

    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }

    $access = GetAccess($checklistID);
    $actualPassword = GetPassword($checklistID);
    $checklistUsername = GetUsername($checklistID);

    if ($access === "Public editable" or (($givenPassword === $actualPassword) and ($actualPassword !== null)) or ($loggedin and $username === $checklistUsername)){

        Query("DELETE FROM task WHERE taskID = ?", "s", $taskID);

        $output["status"] = "success";
        $output["taskID"] = $taskID;

    } else if($checklistUsername === null){
        $output["status"] = "fail";
        $output["userChecklist"] = false;
        $output["errorMsg"] = "The current password is wrong!";

    } else{
        $output["status"] = "fail";
        $output["userChecklist"] = true;
        $output["errorMsg"] = "You do not have permission to delete a task to this checklist!";
        
    }
    echo(json_encode($output));
}
?>