<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //retrieve data from post
    $checklistID = $_POST["checklistID"];
    $givenPassword = $_POST["password"];

    //get key varibles from checklist database
    $actualPassword = GetPassword($checklistID);

    //define useful varibles
    if ($actualPassword === null){
        $passwordSet = false;
        } else {
        $passwordSet = true;
    }

    //response
    if (($givenPassword === $actualPassword) and $passwordSet){
       $output["status"] = "success";
    } else{
       $output["status"] = "fail";
       $output["errorMsg"] = "The current password is wrong!";
    }

    echo(json_encode($output));
}
?>