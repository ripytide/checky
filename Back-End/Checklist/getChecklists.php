<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }

    if ($loggedin){

        $result = Query("SELECT * FROM checklists WHERE username = ?", "s", $username);

        if ($result->num_rows === 0){
            $output["status"] = "success";
            $output["errorMsg"] = "no tasks for that checklist";

        } else{
            $output["status"] = "success";

            while($row = $result->fetch_assoc()){
                $output["results"][] = $row;
            }
        }
    } else{
        $output["status"] = "fail";
        $output["errorMsg"] = "You need to be logged in to use the My Checklists page";
    }

    echo(json_encode($output));
}
?>



