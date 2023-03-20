<?php

if(isset($_POST["game"]))
{
    $gameName = $_POST["game"];
    
    $output = "location: ../Sites/";
    $output .= $gameName;
    $output .= ".php";

    header($output);
    exit();
}else
{
    header("location: ../index.php");
    exit();
}