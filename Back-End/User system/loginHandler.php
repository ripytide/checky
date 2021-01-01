<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //requires connection to database
    require("../connect.php");

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
        $output["userErrorMsg"] = "";
        $output["passErrorMsg"] = "";

    } else {
        $output["status"] = "fail";
        $output["userErrorMsg"] = $feedback[0];
        $output["passErrorMsg"] = $feedback[1];
    }

    echo(json_encode($output));
}

function IsValidCredentials($username, $password){
    require("../connect.php");

	$userErrorMsg = "";
	$passErrorMsg = "";

    //prepare, bind and execute the statement
    $stmt = $conn->prepare("SELECT userPassword FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    //get the Result
    $result = $stmt->get_result();

    //close connection
    $stmt->close();
    $conn->close();

    //if username not found
    if ($result->num_rows === 0){
        $userErrorMsg .= "That username does not exist";
    } else{

		$row = $result->fetch_assoc();
		if ($password !== $row["userPassword"]) {
			$passErrorMsg = "That password does not match that username";
		}
	}
    
    return(array($userErrorMsg, $passErrorMsg));
}

?>