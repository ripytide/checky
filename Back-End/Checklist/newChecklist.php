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

    $idArray = GetUniqueChecklistID(4);

    if ($idArray["status"] === "unique" and $loggedin){

        //open a new file which also creates it
        $newFile = fopen("../../Front-Facing/checklists/" . $idArray["ID"] . ".php", "w");

        //make the new file require the generic checklist html
        fwrite($newFile, "<?php require(\"../checklist.php\"); ?>");
        fclose($newFile);

        Query('INSERT INTO checklist VALUES (?, ?, NULL, NULL, "Private")', "ss", $idArray["ID"], $username);

        $output["status"] = "success";
        $output["checklistID"] = $idArray["ID"];

    } else{
        $output["status"] = "fail";
    }
    echo(json_encode($output));
}

function GetUniqueChecklistID($length){

    $loop = true;
    $increment = 0;

    while ($loop){

        $increment++;

        //get a rand string
        $string = GenerateString($length);

        $result = Query("SELECT checklistID FROM checklist WHERE checklistID = ?", "s", $string);

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


