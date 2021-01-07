<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {

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

        echo(json_encode($output));
    } else{
        
        $output["status"] = "fail";
        $output["errorMsg"] = "You do not have permission to delete from this checklist or the current password is wrong!";

        echo(json_encode($output));
    }
}
?>