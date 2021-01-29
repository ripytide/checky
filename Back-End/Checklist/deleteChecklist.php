<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //retrieve data from post
    $checklistID = $_POST["checklistID"];
    
    $checklistUsername = GetUsername($checklistID);

    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $loggedin = true;
        $username = $_SESSION["username"];
    } else{
        $loggedin = false;
    }

    if ($loggedin and $username === $checklistUsername){
        Query("DELETE FROM task WHERE checklistID = ?", "s", $checklistID);

        Query("DELETE FROM checklist WHERE checklistID = ?", "s", $checklistID);

        unlink("../../checklists/" . $checklistID . ".php");

        $output["status"] = "success";
        $output["checklistID"] = $checklistID;
    }

    echo(json_encode($output));
}
?>