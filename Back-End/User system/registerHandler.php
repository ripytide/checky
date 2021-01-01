<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //requires connection to database
    require("../connect.php");

    //define empty variables
    $username = $password = "";

    //retrieve user/pass from post request
	$username = $_POST["username"];
    $password = $_POST["password"];
    
    

    $userErrorMsg = IsValidUsername($username);
    $passErrorMsg = IsValidPassword($password);

    if ($userErrorMsg === "" and $passErrorMsg === ""){

        //prepare, bind and execute the statement
        $stmt = $conn->prepare("INSERT INTO users VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        //close connection
        $stmt->close();
        $conn->close();

        $output["status"] = "success";
        $output["userErrorMsg"] = "";
        $output["passErrorMsg"] = "";


    } else {
        $output["status"] = "fail";
        $output["userErrorMsg"] = $userErrorMsg;
        $output["passErrorMsg"] = $passErrorMsg;
    }

    echo(json_encode($output));
}

function IsValidUsername($username){
    require("../connect.php");

    $userErrorMsg = "";

    //becomes true if the username contains anthing non alphanumeric
    if (preg_match("/([^a-zA-Z0-9])([\\r\\n]*)/", $username)){
        $userErrorMsg .= " Your username contains invalid characters";
    }

    if (mb_strlen($username) > 16){
        $userErrorMsg .= " Your username is too long";
    }

    if (mb_strlen($username) < 3){
        $userErrorMsg .= " Your username is too short";
    }

    //prepare, bind and execute the statement
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    //get the Result
    $result = $stmt->get_result();

    //close connection
    $stmt->close();
    $conn->close();

    //if not unique
    if ($result->num_rows !== 0){
        $userErrorMsg .= "That username already exists";
    }
    
    return($userErrorMsg);
}

function IsValidPassword($password){
    require("../connect.php");

    $passErrorMsg = "";

    //becomes true if there is no number in the password
    if (!preg_match("/.*[0-9].*/", $password)){
        $passErrorMsg .= " Your password needs a number";
    }

    //becomes true if there is no lowercase letter in the password
    if (!preg_match("/.*[a-z].*/", $password)){
        $passErrorMsg .= " Your password needs a lowercase letter";
    }

    //becomes true if there is no uppecase letter in the password
    if (!preg_match("/.*[A-Z].*/", $password)){
        $passErrorMsg .= " Your password needs an UPPERCASE letter";
    }

    if (mb_strlen($password) > 16){
        $passErrorMsg .= " Your password is too long";
    }

    if (mb_strlen($password) < 3){
        $passErrorMsg .= " Your password is too short";
    }
    
    return($passErrorMsg);
}
?>
