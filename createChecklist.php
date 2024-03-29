<?php
//enable sql access functions such as query
require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

//start session
session_start();

//define so useful boolean variable for use during logic section
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $loggedin = true;
    $username = $_SESSION["username"];
} else{
    $loggedin = false;
}

//get a new ID that does not yet exist is the database
$idArray = GetUniqueChecklistID(4);

//if ID is in fact unique and the user is logged in
if ($idArray["status"] === "unique" and $loggedin){

    //open a new file which also creates it which is what i want to do
    $newFile = fopen("checklists/" . $idArray["ID"] . ".php", "w");

    //make the new file require the generic checklist html
    fwrite($newFile, "<?php require(\"../checklist.php\"); ?>");
    //close file to write changes
    fclose($newFile);

    //add new checklist to the checklists table as private as is a logged in users'
    Query('INSERT INTO checklists VALUES (?, ?, NULL, NULL, "Private")', "ss", $idArray["ID"], $username);

    //set status to success to tell the requestee that the operation was completed
    $output["status"] = "success";
    
    //send back the ID
    $output["checklistID"] = $idArray["ID"];
    
//if the user is not logged in
} else if ($idArray["status"] === "unique" and !$loggedin){
    
    //open a new file which also creates it
    $newFile = fopen("checklists/" . $idArray["ID"] . ".php", "w");

    //make the new file require the generic checklist
    fwrite($newFile, "<?php require(\"../checklist.php\"); ?>");
    
    //close file to save changes
    fclose($newFile);

    //add new checklist as public access mode
    Query('INSERT INTO checklists VALUES (?, NULL, NULL, NULL, "Public editable")', "s", $idArray["ID"]);
    
    //send back a success status
    $output["status"] = "success";
    
    //send back the ID
    $output["checklistID"] = $idArray["ID"];
} else {
    //unexpected file code flow so send back fail status
    $output["status"] = "fail";
}

//redirect browser to the new checklist page
header("Location: checklists/" . $idArray["ID"]);

//a function to find a unique length string of length $length
function GetUniqueChecklistID($length){

    //set the looping variables
    $loop = true;
    $increment = 0;
    
    //a standard while loop
    while ($loop){
        
        //this increments the $increment variable by one
        $increment++;

        //get a rand string
        $string = GenerateString($length);

        //select checklistID from the checklist table to check if the new code is unique
        $result = Query("SELECT checklistID FROM checklists WHERE checklistID = ?", "s", $string);

        //if unique end loop
        if ($result->num_rows === 0){
            //set the $loop variable to false
            $loop = false;
            //send status as unique
            $output["status"] = "unique";
            //send back the ID itself
            $output["ID"] = $string;

            //to prevent infinite loop
        } else if($increment > 100){
            //if not unique and failed to find unique code 100 times then the function returns to prevent infinite loops
            $loop = false;
            //send back the status as not unique
            $output["status"] = "not unique";
        }
    }
    //returns the results of the function
    return($output);
}
?>
