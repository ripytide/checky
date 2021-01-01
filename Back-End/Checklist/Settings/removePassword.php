<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //requires connection to database
    require("../../connect.php");

    $password = $_POST["password"];
    $checklistID = $_POST["checklistID"];

    
    

    require("../../functions.php");
    $actualPassword = GetPassword($checklistID);

    if ((($password === $actualPassword) and ($actualPassword !== null))){
        $validPass = true;
    } else{
        $validPass = false;
    }

    if ($validPass){
        
        //prepare, bind and execute the statement
        $stmt = $conn->prepare("UPDATE checklist SET checklistPassword = NULL WHERE checklistID = ?");
        $stmt->bind_param("s", $_POST["checklistID"]);
        $stmt->execute();

        //prepare, bind and execute the statement
        $stmt = $conn->prepare('UPDATE checklist SET access = "Public editable" WHERE checklistID = ?');
        $stmt->bind_param("s", $_POST["checklistID"]);
        $stmt->execute();

        //close connection
        $stmt->close();
        $conn->close();

        $output["status"] = "success";
        $output["currentPassErrorMsg"] = "";

    } else {
        $output["status"] = "fail";
        $output["currentPassErrorMsg"] = "This password is incorrect";
    }

    echo(json_encode($output));
}
?>

