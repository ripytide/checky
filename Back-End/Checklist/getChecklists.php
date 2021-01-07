<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }

    if ($loggedin){

        $result = Query("SELECT * FROM checklist WHERE username = ?", "s", $username);

        if ($result->num_rows === 0){
            $output["status"] = "caution";
            $output["error"] = "no tasks for that checklist";

        } else{
            $output["status"] = "success";

            while($row = $result->fetch_assoc()){
                $output["results"][] = $row;
            }
        }
    } else{
        $output["status"] = "fail";
    }

    echo(json_encode($output));
}
?>



