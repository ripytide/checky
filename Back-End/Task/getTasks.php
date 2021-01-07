<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //retrieve data from post
    $checklistID = $_POST["checklistID"];
    $givenPassword = $_POST["password"];

    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }

    $access = GetAccess($checklistID);
    $actualPassword = GetPassword($checklistID);
    $checklistUsername = GetUsername($checklistID);

    if ($access === "Public editable" or $access === "Public not editable" or (($givenPassword === $actualPassword) and ($actualPassword !== null)) or ($loggedin and $username === $checklistUsername)){

        $result = Query("SELECT * FROM task WHERE checklistID = ?", "s", $checklistID);

        $output["status"] = "success";

        if ($result->num_rows === 0){
            $output["status"] = "caution";
            $output["error"] = "no tasks for that checklist";

        } else{
            $output["status"] = "success";

            while($row = $result->fetch_assoc()){
                $output["results"][] = $row;
            }
        }

    } else if (!$actualPassword){
        $output["status"] = "fail";
        $output["errorMsg"] = "You do not have permission to view this checklist!";

    } else if (!(($givenPassword === $actualPassword) and ($actualPassword !== null))){
        $output["status"] = "fail";
        $output["errorMsg"] = "The current password is incorrect!";

    } else{
        $output["status"] = "fail";

    }

    echo(json_encode($output));
}
?>

