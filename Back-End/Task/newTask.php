<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //requires connection to database
    require("../connect.php");

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

    require("../functions.php");

    $access = GetAccess($checklistID);
    $actualPassword = GetPassword($checklistID);
    $checklistUsername = GetUsername($checklistID);

    

    $idArray = GetUniqueID(4, "task");

    if ($access === "Public editable" or (($givenPassword === $actualPassword) and ($actualPassword !== null)) or ($loggedin and $username === $checklistUsername)){
        if ($idArray["status"] === "unique"){

            //prepare, bind and execute the statement
            $stmt = $conn->prepare('INSERT INTO task VALUES (?, ?, NULL, NULL, "None", "Not started", 0)');
            $stmt->bind_param("ss", $idArray["ID"], $checklistID);
            $stmt->execute();

            //close connection
            $stmt->close();
            $conn->close();

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


function GenerateString($len){
    $string = "";
    for ($i=0; $i < $len; $i++) {

        if (rand(0, 1)){
            $string .= chr(rand(65, 90));
        } else{
            $string .= chr(rand(97, 122));
        }
    }

    return($string);
}


function GetUniqueID($length){
    require("../connect.php");

    

    $loop = true;
    $increment = 0;
    while ($loop){

        $increment++;

        //get a rand string
        $string = GenerateString($length);

        //prepare, bind and execute the statement depending on the table wanted
        $stmt = $conn->prepare("SELECT taskID FROM task WHERE taskID = ?");
        $stmt->bind_param("s", $string);
        $stmt->execute();

        //get the Result
        $result = $stmt->get_result();

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

    //close connection
    $stmt->close();
    $conn->close();

    return($output);
}
?>


