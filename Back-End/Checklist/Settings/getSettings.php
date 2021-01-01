<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    

    $checklistID = $_POST["checklistID"];

    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }

    require("../../functions.php");
    $actualPassword = GetPassword($checklistID);
    $checklistUsername = GetUsername($checklistID);
    $access = GetAccess($checklistID);

    if($loggedin and $username === $checklistUsername){
        $output["status"] = "success";
        $output["access"] = $access;
        $output["userChecklist"] = true;

    } else if ($checklistUsername === null){
        if ($actualPassword){
            $output["status"] = "success";
            $output["access"] = $access;
            $output["passwordSet"] = true;
            $output["userChecklist"] = false;

        } else{
            $output["status"] = "success";
            $output["access"] = $access;
            $output["passwordSet"] = false;
            $output["userChecklist"] = false;

        }
    } else if($loggedin and $username !== $checklistUsername){
        $output["status"] = "fail";
        $output["errorMsg"] = "This is not you checklist therefore you do not have access to the management settings";
    } else{
        $output["status"] = "fail";
        $output["errorMsg"] = "This is not you checklist therefore you do not have access to the management settings";
    }

    echo(json_encode($output));
}

?>