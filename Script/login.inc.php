<?php

if(isset($_POST["submit"]))
{
    $username = $_POST["username"];
    $pwd = $_POST["password"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($username, $pwd) !== false)
    {
        header("location: ../index.php?errorLogin=emptyInput");
        exit();
    }
    if(activeUser($username, $conn) == false)
    {
        header("location: ../index.php?errorLogin=noActive");
        exit();
    }

    loginUser($conn, $username, $pwd);
}else if(isset($_POST["resend"]))
{
    $username = $_POST["username"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    
    if (empty($username))
    {
        header("location: ../index.php?errorLogin=emptyResend");
        exit();
    }

    resend($username, $conn);
    
}else
{
    header("location: ../index.php");
    exit();
}