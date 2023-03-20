<?php

session_start();

if(isset($_POST["submit"]))
{
    $gameName = $_POST["gameInput"];
    $score = $_POST["scoreInput"];
    $dif = $_POST["gameDif"];
    $time = $_POST["gameTime"];
    $userId = $_SESSION["userid"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    AddScore($conn, $gameName, $score, $userId, $time, $dif);

}else
{
    header("location: ../index.php");
    exit();
}