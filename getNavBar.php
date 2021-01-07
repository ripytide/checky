<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    require("loggedinNavBar.php");
} else{
    require("loggedoutNavBar.html");
}
?>


