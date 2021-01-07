<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $password = $_POST["password"];
    $checklistID = $_POST["checklistID"];

    $actualPassword = GetPassword($checklistID);

    if ((($password === $actualPassword) and ($actualPassword !== null))){
        $validPass = true;
    } else{
        $validPass = false;
    }

    if ($validPass){
        Query("UPDATE checklist SET checklistPassword = NULL WHERE checklistID = ?", "s",  $_POST["checklistID"]);
        
        Query('UPDATE checklist SET access = "Public editable" WHERE checklistID = ?', "s", $_POST["checklistID"]);

        $output["status"] = "success";
        $output["currentPassErrorMsg"] = "";
    } else {
        $output["status"] = "fail";
        $output["currentPassErrorMsg"] = "This password is incorrect";
    }

    echo(json_encode($output));
}
?>

