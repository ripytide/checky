<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //requires connection to database
    require("../connect.php");

    //retrieve data from post
    $taskID = $_POST["taskID"];
    $checklistID = $_POST["checklistID"];
    $givenPassword = $_POST["password"];

    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }
    
    require("../functions.php");

    $access = GetAccess($checklistID);
    $actualPassword = GetPassword($checklistID);
    $checklistUsername = GetUsername($checklistID);

    if ($access === "Public editable" or (($givenPassword === $actualPassword) and ($actualPassword !== null)) or ($loggedin and $username === $checklistUsername)){

        //prepare, bind and execute the statement depending on which column needed.
        $stmt = $conn->prepare("DELETE FROM task WHERE taskID = ?");
        $stmt->bind_param("s", $taskID);
        $stmt->execute();

        //close connection
        $stmt->close();
        $conn->close();

        

        $output["status"] = "success";
        $output["taskID"] = $taskID;

        echo(json_encode($output));
    } else{
        
        $output["status"] = "fail";
        $output["errorMsg"] = "You do not have permission to delete from this checklist or the current password is wrong!";

        echo(json_encode($output));
    }
}
?>