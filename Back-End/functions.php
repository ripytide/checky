<?php


function GetPassword($checklistID){
    require("connect.php");

    //prepare, bind and execute the statement depending on which column needed.
    $stmt = $conn->prepare("SELECT checklistPassword FROM checklist WHERE checklistID = ?");
    $stmt->bind_param("s", $checklistID);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    //close connection
    $stmt->close();
    $conn->close();

    $password = $result->fetch_assoc()["checklistPassword"];

    return($password);
}

function GetAccess($checklistID){
    require("connect.php");

    //prepare, bind and execute the statement depending on which column needed.
    $stmt = $conn->prepare("SELECT access FROM checklist WHERE checklistID = ?");
    $stmt->bind_param("s", $checklistID);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    //close connection
    $stmt->close();
    $conn->close();

    $access = $result->fetch_assoc()["access"];

    return($access);
}

function GetUsername($checklistID){
    require("connect.php");

    //prepare, bind and execute the statement depending on which column needed.
    $stmt = $conn->prepare("SELECT username FROM checklist WHERE checklistID = ?");
    $stmt->bind_param("s", $checklistID);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    //close connection
    $stmt->close();
    $conn->close();

    $username = $result->fetch_assoc()["username"];

    return($username);
}
?>