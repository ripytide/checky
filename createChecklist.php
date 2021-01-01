<?php
//requires connection to database
require("Back-End/connect.php");
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $loggedin = true;
    $username = $_SESSION["username"];
} else{
    $loggedin = false;
}

$idArray = GetUniqueID(4, "checklist");
if ($idArray["status"] === "unique" and $loggedin){

    //open a new file which also creates it
    $newFile = fopen("checklists/" . $idArray["ID"] . ".php", "w");

    //make the new file require the generic checklist html
    fwrite($newFile, "<?php require(\"../checklist.php\"); ?>");

    fclose($newFile);

    //prepare, bind and execute the statement
    $stmt = $conn->prepare('INSERT INTO checklist VALUES (?, ?, NULL, NULL, "Private")');
    $stmt->bind_param("ss", $idArray["ID"], $username);
    $stmt->execute();

    //close connection
    $stmt->close();
    $conn->close();

    
    $output["status"] = "success";
    $output["checklistID"] = $idArray["ID"];
    
} else if ($idArray["status"] === "unique" and !$loggedin){
    //open a new file which also creates it
    $newFile = fopen("checklists/" . $idArray["ID"] . ".php", "w");

    //make the new file require the generic checklist
    fwrite($newFile, "<?php require(\"../checklist.php\"); ?>");

    fclose($newFile);

    //prepare, bind and execute the statement
    $stmt = $conn->prepare('INSERT INTO checklist VALUES (?, Null, NULL, NULL, "Public editable")');
    $stmt->bind_param("s", $idArray["ID"]);
    $stmt->execute();

    //close connection
    $stmt->close();
    $conn->close();

    
    $output["status"] = "success";
    $output["checklistID"] = $idArray["ID"];
} else {
    $output["status"] = "fail";
}

header("Location: checklists/" . $idArray["ID"]);



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


function GetUniqueID($length, $table){
    require("Back-End/connect.php");

    

    $loop = true;
    $increment = 0;
    while ($loop){

        $increment++;

        //get a rand string
        $string = GenerateString($length);

        //prepare, bind and execute the statement depending on the table wanted
        $stmt = $conn->prepare("SELECT checklistID FROM checklist WHERE checklistID = ?");
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