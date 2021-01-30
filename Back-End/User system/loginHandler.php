<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //define empty variables
    $username = $password = "";

    //retrieve user/pass from post request
	$username = $_POST["username"];
    $password = $_POST["password"];
    
	$feedback = IsValidCredentials($username, $password);

    if ($feedback[0] === "" and $feedback[1] === ""){

		//credentials are correct so start a session
		session_start();

		//store non-sensitive data in session variable
		$_SESSION["loggedin"] = true;
		$_SESSION["username"] = $username;;
		
		//commit session
        session_commit();

        $output["status"] = "success";
        
    } else {
        $output["status"] = "fail";
        $output["userErrorMsg"] = $feedback[0];
        $output["passErrorMsg"] = $feedback[1];
    }

    echo(json_encode($output));
}

function IsValidCredentials($username, $password){

	$userErrorMsg = "";
	$passErrorMsg = "";

    //get that users hash
    $result = Query("SELECT userHash FROM users WHERE username = ?", "s", $username);

    //if username not found
    if ($result->num_rows === 0){
        $userErrorMsg .= "That username does not exist";
    } else if (!password_verify($password, $result->fetch_assoc()["userHash"])){
		$passErrorMsg = "That password does not match that username";
	}
    
    return(array($userErrorMsg, $passErrorMsg));
}
?>