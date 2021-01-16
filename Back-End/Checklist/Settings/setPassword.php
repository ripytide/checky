<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //retrieve pass from post request
    $password = $_POST["password"];
    $checklistID = $_POST["checklistID"];
    
    $actualPassword = GetPassword($checklistID);

    if ($actualPassword)
    {
        $feedback = "You cannot set a password as you already have a password";
    } else{
        $feedback = IsValidPassword($password);
    }

    if ($feedback === ""){
        Query("UPDATE checklist SET checklistPassword = ? WHERE checklistID = ?", "ss", $password, $_POST["checklistID"]);

        $output["status"] = "success";
        $output["passErrorMsg"] = "";

    } else {
        $output["status"] = "fail";
        $output["passErrorMsg"] = $feedback;
    }

    echo(json_encode($output));
}

function IsValidPassword($password){
    $errorList = Array();

    //becomes true if there is no number in the password
    if (!preg_match("/.*[0-9].*/", $password)){
        array_push($errorList, "Your password needs a number");
    }

    //becomes true if there is no lowercase letter in the password
    if (!preg_match("/.*[a-z].*/", $password)){
        array_push($errorList, "Your password needs a lowercase letter");
    }

    //becomes true if there is no uppecase letter in the password
    if (!preg_match("/.*[A-Z].*/", $password)){
        array_push($errorList, "Your password needs an UPPERCASE letter");
    }

    if (mb_strlen($password) > 16){
        array_push($errorList, "Your password is too long");
    }

    if (mb_strlen($password) < 3){
        array_push($errorList, "Your password is too short");
    }
    
    return(implode("<br>", $errorList));
}

?>