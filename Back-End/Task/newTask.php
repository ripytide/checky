<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //data from post
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

    $idArray = GetUniqueTaskID(4, "task");

    if ($access === "Public editable" or (($givenPassword === $actualPassword) and ($actualPassword !== null)) or ($loggedin and $username === $checklistUsername)){
        if ($idArray["status"] === "unique"){

            Query('INSERT INTO task VALUES (?, ?, NULL, NULL, "None", "Not started", 0)', "ss", $idArray["ID"], $checklistID);

            $output["status"] = "success";
            $output["taskID"] = $idArray["ID"];

        } else{
            $output["status"] = "fail";
        }
    } else{
        $output["status"] = "fail";
        $output["errorMsg"] = "You do not have permission to add a task to this checklist or the current password is wrong!";
    }

    echo(json_encode($output));
}

function GetUniqueTaskID($length){
    $loop = true;
    $increment = 0;

    while ($loop){
        $increment++;

        //get a rand string
        $string = GenerateString($length);

        //get the Result
        $result = Query("SELECT taskID FROM task WHERE taskID = ?", "s", $string);

        //if unique end loop
        if ($result->num_rows === 0){
            $loop = false;
            $output["status"] = "unique";
            $output["ID"] = $string;

            //to prevent infinite loop
        } else if($increment > 100){
            $loop = false;
            $output["status"] = "not unique";
        }
    }

    return($output);
}
?>


