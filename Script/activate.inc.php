<?php

    require_once 'dbh.inc.php';

	if(!empty($_GET["id"])) {

        $sql = "UPDATE users set Status = ? WHERE link = ? ";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?error=stmtFailed");
            exit();
        }
        $state = 1;

        mysqli_stmt_bind_param($stmt, "is", $state, $_GET["id"]);
        if (mysqli_stmt_execute($stmt))
        {
            echo '<script>alert("Your account is activated.");
            window.location.href="../index.php";</script>';
            
            
        }else{
            echo '<script>alert("Problem in account activation, try again.")
            window.location.href="../index.php";</script>';
            
        }
        
            
        
        mysqli_stmt_close($stmt);

	}