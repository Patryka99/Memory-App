<?php

session_start();

if(isset($_POST["submit"]) || isset($_POST['leaderBoard']))
{
    $gameName = $_POST["gameInput"];
    $score = $_POST["scoreInput"];
    $dif = $_POST["gameDif"];
    $time = $_POST["gameTime"];
    $userId = $_SESSION["userid"];
    $userName = $_SESSION["username"];

    $again = true;
    if(isset($_POST['leaderBoard']))
    {
        $again = false;
    }

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    AddScore($conn, $gameName, $score, $userId, $time, $dif, $again, $userName);

}else
{
    header("location: ../index.php");
    exit();
}