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
    $hash = GetHash($checklistID);
    $checklistUsername = GetUsername($checklistID);

    if ($access === "Public editable" or ((password_verify($givenPassword, $hash)) and ($hash)) or ($loggedin and $username === $checklistUsername)){

        Query("DELETE FROM tasks WHERE taskID = ?", "s", $taskID);

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