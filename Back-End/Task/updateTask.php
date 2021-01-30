<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //retrieve data from post
	$taskID = $_POST["taskID"];
    $column = $_POST["column"];
    $newValue = $_POST["newValue"];
    $givenPassword = $_POST["password"];
    $checklistID = $_POST["checklistID"];

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

    $valid = true;

    if ($column === "taskTitle") {

        $errorMsg = IsValidTaskTitle($newValue);
        if ($errorMsg === ""){
        } else{
            $valid = false;

            $output["status"] = "fail";
            $output["taskID"] = $taskID;
            $output["column"] = $column;
            $output["errorMsg"] = $errorMsg;

        }
    }else if ($column === "description") {

        $errorMsg = IsValidDescription($newValue);
        if ($errorMsg === ""){
        } else{
            $valid = false;

            $output["status"] = "fail";
            $output["taskID"] = $taskID;
            $output["column"] = $column;
            $output["errorMsg"] = $errorMsg;
        }
    }else if (in_array($column, array("checkbox", "status", "priority"))){
    }else{
        $valid = false;
        
        $output["status"] = "fail";
        $output["taskID"] = $taskID;

    }

    if ($access === "Public editable" or ((password_verify($givenPassword, $hash)) and ($hash)) or ($loggedin and $username === $checklistUsername)){
        if ($valid){
            Query("UPDATE tasks SET $column = ? WHERE taskID = ?", "ss", $newValue, $taskID);

            $output["status"] = "success";
            $output["taskID"] = $taskID;
            $output["column"] = $column;
        }
    } else if($checklistUsername === null and (($givenPassword === $actualPassword) and ($actualPassword !== null))){
        $output["status"] = "fail";
        $output["userChecklist"] = false;
        $output["errorMsg"] = "The current password is wrong!";
    } else{
        $output["status"] = "fail";
        $output["userChecklist"] = true;
        $output["errorMsg"] = "You do not have permission to update a task to this checklist!";
    }
    
    echo(json_encode($output));
}

function IsValidTaskTitle($title){
    if (mb_strlen($title) <= 16){
        return("");
    } else{
        return("This Title is too long");
    }
}

function IsValidDescription($desc){
    if(mb_strlen($desc) <= 256){
        return("");
    } else{
        return("This description is too long");
    }
}
?>





