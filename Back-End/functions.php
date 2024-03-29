<?php
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

function GetHash($checklistID){
    $result = Query("SELECT checklistHash FROM checklists WHERE checklistID = ?", "s", $checklistID);

    $hash = $result->fetch_assoc()["checklistHash"];

    return($hash);
}

function GetAccess($checklistID){
    $result = Query("SELECT access FROM checklists WHERE checklistID = ?", "s", $checklistID);

    $access = $result->fetch_assoc()["access"];

    return($access);
}

function GetUsername($checklistID){
    $result = Query("SELECT username FROM checklists WHERE checklistID = ?", "s", $checklistID);

    $username = $result->fetch_assoc()["username"];

    return($username);
}

function GetChecklistTitle($checklistID){
    $result = Query("SELECT checklistTitle FROM checklists WHERE checklistID = ?", "s", $checklistID);

    $checklistTitle = $result->fetch_assoc()["checklistTitle"];

    return($checklistTitle);
}

function Connect(){
    $db_servername = "localhost";
    $db_username = "u108222632_ripytide";
    $db_password = "1StapleearphoneS9";
    $dbname = "u108222632_checky";

    // Create connection
    $conn = new mysqli($db_servername, $db_username, $db_password, $dbname);

    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function Query($statement, $types, ...$variables){
    $conn = Connect();

    //prepare, bind and execute the statement
    $stmt = $conn->prepare($statement);
    $stmt->bind_param($types, ...$variables);
    $stmt->execute();

    $result = $stmt->get_result();

    //close connection
    $stmt->close();
    $conn->close();

    return $result;
}
?>