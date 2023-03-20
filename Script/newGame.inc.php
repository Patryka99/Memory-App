<?php

if(isset($_POST["submit"]))
{
    $gameName = $_POST["game"];

    if($gameName == "FlipACard")
        {
            header("location: ../Sites/FlipACard.php");
            exit();
        }else if($gameName == "Crossword"){
            header("location: ../Sites/GameStart.php?game=Crossword");
            exit();
        }else if($gameName == "SimonSays"){
            header("location: ../Sites/Simon.php");
            exit();
        }else if($gameName == "Sudoku"){
            header("location: ../Sites/Sudoku.php");
            exit();
        }else if($gameName == "SlidePuzzle"){
            header("location: ../Sites/GameStart.php?game=SlidePuzzle");
            exit();
        }else if($gameName == "MathGame"){
            header("location: ../Sites/MathGame.php");
            exit();
        }else{
            header("location: ../Sites/Games.php");
            exit();
        }
}else
{
    header("location: ../index.php");
    exit();
}