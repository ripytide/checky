<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $checklistID = $_POST["checklistID"];

    $hash = GetHash($checklistID);

    $validPass = password_verify($currentPassword, $hash) && !empty($currentPassword);

    $feedback = IsValidPassword($newPassword);

    if (!$validPass){

        $output["status"] = "fail";
        $output["currentPassErrorMsg"] = "This password is incorrect";
        $output["newPassErrorMsg"] = "";

    } else if ($feedback === ""){
        Query("UPDATE checklists SET checklistHash = ? WHERE checklistID = ?", "ss", password_hash($newPassword, PASSWORD_DEFAULT), $_POST["checklistID"]);

        $output["status"] = "success";
        $output["currentPassErrorMsg"] = "";
        $output["newPassErrorMsg"] = "";

    } else {
        $output["status"] = "fail";
        $output["currentPassErrorMsg"] = "";
        $output["newPassErrorMsg"] = $feedback;
    }
    echo(json_encode($output));
}

function IsValidPassword($password){
    $passErrorMsg = "";

    //becomes true if there is no number in the password
    if (!preg_match("/.*[0-9].*/", $password)){
        $passErrorMsg .= " Your password needs a number";
    }

    //becomes true if there is no lowercase letter in the password
    if (!preg_match("/.*[a-z].*/", $password)){
        $passErrorMsg .= " Your password needs a lowercase letter";
    }

    //becomes true if there is no uppecase letter in the password
    if (!preg_match("/.*[A-Z].*/", $password)){
        $passErrorMsg .= " Your password needs an UPPERCASE letter";
    }

    if (mb_strlen($password) > 16){
        $passErrorMsg .= " Your password is too long";
    }

    if (mb_strlen($password) < 3){
        $passErrorMsg .= " Your password is too short";
    }
    
    return($passErrorMsg);
}
?>