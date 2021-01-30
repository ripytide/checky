<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //retrieve data from post
    $checklistID = $_POST["checklistID"];
    $givenPassword = $_POST["password"];

    //get key varibles from checklist database
    $hash = GetHash($checklistID);

    //define useful varibles
    if ($hash){
        $passwordSet = true;
        } else {
        $passwordSet = false;
    }

    //response
    if ((password_verify($givenPassword, $hash)) and $passwordSet){
       $output["status"] = "success";
    } else{
       $output["status"] = "fail";
       $output["errorMsg"] = "The current password is wrong!";
    }

    echo(json_encode($output));
}
?>