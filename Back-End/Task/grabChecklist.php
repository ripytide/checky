<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //retrieve data from post
    $checklistID = $_POST["checklistID"];
    $givenPassword = $_POST["password"];

    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }

    //get key varibles from checklist database
    $access = GetAccess($checklistID);
    $actualPassword = GetPassword($checklistID);
    $checklistUsername = GetUsername($checklistID);

    //define useful varibles
    if ($actualPassword === null){
        $passwordSet = false;
        } else {
        $passwordSet = true;
    }
    if ($checklistUsername === null){
        $userChecklist = false;
    } else {
        $userChecklist = true;
    }


    if ($access === "Public editable" or $access === "Public not editable" or (($givenPassword === $actualPassword) and $passwordSet) or ($loggedin and $username === $checklistUsername)){

        $tasks = Query("SELECT * FROM task WHERE checklistID = ?", "s", $checklistID);

        $output["status"] = "success";
        $output["tasksAccess"] = true;
        $output["access"] = $access;
        $output["userChecklist"] = $userChecklist;
        $output["passwordSet"] = $passwordSet;

        if (($loggedin and $username === $checklistUsername) or (!$userChecklist)){
            $output["settingsAccess"] = true;
        } else {
            $output["settingsAccess"] = false;
        }

        if ($tasks->num_rows === 0){
            $output["errorMsg"] = "no tasks for that checklist";
        } else{
            while($row = $tasks->fetch_assoc()){
                $output["tasks"][] = $row;
            }
        }

    } else if ($userChecklist){
        $output["status"] = "fail";
        $output["tasksAccess"] = false;
        $output["userChecklist"] = true;
        $output["settingsAccess"] = false;

        $output["errorMsg"] = "You do not have permission to view this checklist!";

    } else if ($passwordSet){
        $output["status"] = "fail";
        $output["tasksAccess"] = false;
        $output["userChecklist"] = false;
        $output["settingsAccess"] = false;

        $output["errorMsg"] = "The password is incorrect!";

    } else{
        $output["status"] = "fail";
    }

    echo(json_encode($output));
}
?>