<?php

if(isset($_POST["submit"]))
{
    $name = $_POST["name"];
    $username = $_POST["uid"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];
    $pwdRepeat = $_POST["passwordRepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputSignup($name, $username, $email, $pwd, $pwdRepeat) !== false)
    {
        header("location: ../index.php?errorRegister=emptyInput&1=".$name."&2=".$username."&3=".$email);
        exit();
    }
    if(strongPassword($pwd) !== false)
    {
        header("location: ../index.php?errorRegister=passwordNotStrong&1=".$name."&2=".$username."&3=".$email);
        exit();
    }
    if(invalidName($name) !== false)
    {
        header("location: ../index.php?errorRegister=invalidName&1=".$name."&2=".$username."&3=".$email);
        exit();
    }
    if(invalidUid($username) !== false)
    {
        header("location: ../index.php?errorRegister=invalidUid&1=".$name."&2=".$username."&3=".$email);
        exit();
    }
    if(invalidEmail($email) !== false)
    {
        header("location: ../index.php?errorRegister=invalidEmail&1=".$name."&2=".$username."&3=".$email);
        exit();
    }
    if(pwdMatch($pwd, $pwdRepeat) !== false)
    {
        header("location: ../index.php?errorRegister=passwordNotEqual&1=".$name."&2=".$username."&3=".$email);
        exit();
    }
    if(uidExists($conn, $username, $email) !== false)
    {
        header("location: ../index.php?errorRegister=usernameTaken&1=".$name."&2=".$username."&3=".$email);
        exit();
    }

    createUser($conn, $name, $username, $email, $pwd);
    

}else
{
    header("location: ../index.php");
    exit();
}