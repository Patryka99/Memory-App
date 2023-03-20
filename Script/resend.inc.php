<?php

if(isset($_POST["submit"]))
{
    $username = $_POST["username"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($username, $pwd) !== false)
    {
        header("location: ../index.php?errorLogin=emptyInput");
        exit();
    }

    resend($username, $conn);
}else
{
    header("location: ../index.php");
    exit();
}