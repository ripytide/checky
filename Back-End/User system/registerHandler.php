<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require($_SERVER['DOCUMENT_ROOT'] . "/Back-End/functions.php");

    //define empty variables
    $username = $password = "";

    //retrieve user/pass from post request
	$username = $_POST["username"];
    $password = $_POST["password"];

    $userErrorMsg = IsValidUsername($username);
    $passErrorMsg = IsValidPassword($password);

    if ($userErrorMsg === "" and $passErrorMsg === ""){
        Query("INSERT INTO users VALUES (?, ?)", "ss", $username, $password);

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

    //get the Result
    $result = Query("SELECT username FROM users WHERE username = ?", "s", $username);

    //if not unique
    if ($result->num_rows !== 0){
        $userErrorMsg .= "That username already exists";
    }
    
    return($userErrorMsg);
}

function IsValidPassword($password){
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
