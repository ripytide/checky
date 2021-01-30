<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");
    
    $password = $_POST["password"];
    $checklistID = $_POST["checklistID"];

    $hash = GetHash($checklistID);

    $validPass = password_verify($password, $hash) && !empty($password);

    if ($validPass){
        Query("UPDATE checklists SET checklistHash = NULL WHERE checklistID = ?", "s",  $_POST["checklistID"]);
        
        Query('UPDATE checklists SET access = "Public editable" WHERE checklistID = ?', "s", $_POST["checklistID"]);

        $output["status"] = "success";
        $output["currentPassErrorMsg"] = "";
    } else {
        $output["status"] = "fail";
        $output["currentPassErrorMsg"] = "This password is incorrect";
    }

    echo(json_encode($output));
}
?>

