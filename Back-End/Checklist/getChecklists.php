<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //requires connection to database
    require("../connect.php");

    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }

    if ($loggedin){
        //prepare, bind and execute the statement depending on which column needed.
        $stmt = $conn->prepare("SELECT * FROM checklist WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        //close connection
        $stmt->close();
        $conn->close();

        $output["results"] = array();

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



