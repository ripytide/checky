<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //requires connection to database
    require("../../connect.php");

    //retrieve pass from post request
    $password = $_POST["password"];
    $checklistID = $_POST["checklistID"];
    
    

    require("../../functions.php");
    $actualPassword = GetPassword($checklistID);

    if ($actualPassword)
    {
        $feedback = "You cannot set a password as you already have a password";
    } else{
        $feedback = IsValidPassword($password);
    }

    if ($feedback === ""){

        //prepare, bind and execute the statement
        $stmt = $conn->prepare("UPDATE checklist SET checklistPassword = ? WHERE checklistID = ?");
        $stmt->bind_param("ss", $password, $_POST["checklistID"]);
        $stmt->execute();

        //close connection
        $stmt->close();
        $conn->close();

        $output["status"] = "success";
        $output["passErrorMsg"] = "";

    } else {
        $output["status"] = "fail";
        $output["passErrorMsg"] = $feedback;
    }

    echo(json_encode($output));
}

function IsValidPassword($password){
    require("../../connect.php");

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