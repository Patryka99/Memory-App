<?php

function emptyInputSignup($name, $username, $email, $pwd, $pwdRepeat){
    $result;
    if (empty($name) || empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }else
    {
        $result = false;
    }
    return $result;
}

function invalidName($name){
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $name) || strlen($name) < 3) {
        $result = true;
    }else
    {
        $result = false;
    }
    return $result;
}

function invalidUid($username){
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username) || strlen($username) < 5) {
        $result = true;
    }else
    {
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }else
    {
        $result = false;
    }
    return $result;
}

function strongPassword($pwd){
    $result;
    $uppercase = preg_match('@[A-Z]@', $pwd);
    $lowercase = preg_match('@[a-z]@', $pwd);
    $number    = preg_match('@[0-9]@', $pwd);
    if (strlen($pwd) < 8 || !$uppercase || !$lowercase || !$number) {
        $result = true;
    }else
    {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat){
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }else
    {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail =?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $username, $email, $pwd){
    $bytes = random_bytes(20);
    $linkCode = bin2hex($bytes);
    // $success = False;
    // $actual_link = "http://$_SERVER[HTTP_HOST]" . "/Script/" . "activate.inc.php?id=" . $linkCode;
    // $toEmail = $email;
    // $subject = "User Registration Activation Email";
    // $content = "Thanks for using MemoryApp, Click this link to activate your account. " . $actual_link;
    // $mailHeaders = "From: MemoryApp\r\n";
    // if (mail($toEmail, $subject, $content, $mailHeaders)) {
    //     $message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";
    //     $success = True;
    // }

    $success = True;

    if($success)
    {
        $zmienna = '0000-00-00';
        $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd, UsersDate, Status, link) VALUES (?, ?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?errorRegister=stmtFailed2");
            exit();
        }

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        $state = 1;

        mysqli_stmt_bind_param($stmt, "sssssis", $name, $email, $username, $hashedPwd, $zmienna, $state, $linkCode);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        unset($_POST);
    
        header("location: ../index.php?errorRegister=none");
    }
    else{
        header("location: ../index.php?errorRegister=emailNotSent");
    }
    


    
    
    exit();
}

function emptyInputLogin($username, $pwd){
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    }else
    {
        $result = false;
    }
    return $result;
}

function activeUser($username, $conn){
    $sql = "SELECT * FROM users WHERE usersUid = ? AND Status = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }
    $state = 1;
    
    mysqli_stmt_bind_param($stmt, "si", $username, $state);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
    
}

function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false){
        header("location: ../index.php?errorLogin=wrongLogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false)
    {
        header("location: ../index.php?errorLogin=wrongLogin");
        exit();
    }
    else if($checkPwd === true)
    {
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["username"] = $uidExists["usersName"];
        $_SESSION["useremail"] = $uidExists["usersEmail"];
        $_SESSION["userdate"] = $uidExists["usersDate"];
        header("location: ../index.php");
        exit();
    }
}

function gameExists($conn, $gameName){
    $sql = "SELECT * FROM games WHERE gamesName = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $gameName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}


function AddScore($conn, $gameName, $score, $usersId, $time, $dif, $again, $userName){
    $gameExists = gameExists($conn, $gameName);

    if($gameExists === false){
        header("location: ../index.php");
        exit();
    }

    if($score > 0){
        $sql = "INSERT INTO usersgames (usersId, gamesId, gamesScore, gamesTime, gamesDif, gamesDate) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php");
            exit();
        }
    
        $curDate = date("Y-m-d");
        $gameId = $gameExists["gamesId"];
    
        mysqli_stmt_bind_param($stmt, "iiisss", $usersId, $gameId, $score, $time, $dif, $curDate);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    if($again){
        if($gameName == "FlipACard")
        {
            header("location: ../Sites/FlipACard.php");
            exit();
        }else if($gameName == "Crossword"){
            header("location: ../Sites/GameStart.php?game=Crossword");
            exit();
        }else if($gameName == "SimonSays"){
            header("location: ../Sites/GameStart.php?game=Simon");
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
            header("location: ../index.php");
            exit();
        }
    }else{
        $string = 'location: ../Sites/Scoreboard.php?scoreboard=';
        $string .=$score;
        $string .='&name=';
        $string .=$userName;
        $string .='&game=';
        $string .=$gameName;
        header($string);
        exit();
    }
    
    

}

function GetScoreboard($conn, $gameName){
    $sql = "SELECT ROW_NUMBER() OVER(ORDER BY MAX(ug.gamesScore) DESC) AS RANK, u.usersName, MAX(ug.gamesScore) as gamesScore, u.usersUid from usersgames ug
    INNER JOIN users u on u.usersId = ug.usersId
    INNER JOIN games g on g.gamesId = ug.gamesId
    WHERE g.gamesName = ? GROUP BY u.usersUid ORDER BY MAX(ug.gamesScore) DESC";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $gameName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($resultData != null){
        return $resultData;
    }else{
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function getBestScore($conn, $gameName, $useruid){
    $sql = "SELECT MAX(ug.gamesScore) AS score, YEAR(ug.gamesDate) AS date2 FROM usersgames ug
    INNER JOIN users u on u.usersId = ug.usersId
    INNER JOIN games g on g.gamesId = ug.gamesId
    WHERE u.usersUid = ? AND g.gamesName = ? GROUP BY YEAR(ug.gamesDate) ORDER BY ug.gamesDate DESC ";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $useruid, $gameName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($resultData != null){
        return $resultData;
    }else{
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function getBestScore2($conn, $gameName, $useruid, $diff){
    $sql = "SELECT MAX(ug.gamesScore) AS score, YEAR(ug.gamesDate) AS date2 FROM usersgames ug
    INNER JOIN users u on u.usersId = ug.usersId
    INNER JOIN games g on g.gamesId = ug.gamesId
    WHERE u.usersUid = ? AND g.gamesName = ? AND ug.gamesDif = ? GROUP BY YEAR(ug.gamesDate) ORDER BY ug.gamesDate DESC ";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $useruid, $gameName, $diff);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($resultData != null){
        return $resultData;
    }else{
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function getChartInfo($conn, $gameName, $userUid){
    $sql = "SELECT ug.gamesScore, ug.gamesDate from usersgames ug
    INNER JOIN users u on u.usersId = ug.usersId
    INNER JOIN games g on g.gamesId = ug.gamesId
    WHERE g.gamesName = ? AND u.usersUid = ? ORDER BY ug.gamesDate ASC";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $gameName, $userUid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $resultData;
    }else{
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function getChartInfo2($conn, $gameName, $userUid, $diff){
    $sql = "SELECT ug.gamesScore, ug.gamesDate from usersgames ug
    INNER JOIN users u on u.usersId = ug.usersId
    INNER JOIN games g on g.gamesId = ug.gamesId
    WHERE g.gamesName = ? AND u.usersUid = ? AND ug.gamesDif = ? ORDER BY ug.gamesDate ASC";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $gameName, $userUid, $diff);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $resultData;
    }else{
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function reSend($username, $conn){
    $sql = "SELECT link,usersEmail from users WHERE usersUid = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        $linkCode = $row['link'];
        $email = $row['usersEmail'];
    }else{
        header("location: ../index.php");
        exit();
    }

    $actual_link = "http://$_SERVER[HTTP_HOST]" . "/Script/" . "activate.inc.php?id=" . $linkCode;
    $toEmail = $email;
    $subject = "User Registration Activation Email";
    $content = "Thanks for using MemoryApp, Click this link to activate your account. " . $actual_link;
    $mailHeaders = "From: MemoryApp\r\n";
    if (mail($toEmail, $subject, $content, $mailHeaders)) {
        $message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";
        $success = True;
    }
    else{
        header("location: ../index.php");
        exit();
    }

    header("location: ../index.php?errorLogin=Resended");
    
    mysqli_stmt_close($stmt);
}