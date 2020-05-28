<?php 
if (isset ($_POST['login-submit'])) {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'root';
    $dbname = 'users';
    $conn = mysqli_connect ($dbhost, $dbuser, $dbpass, $dbname);
    if(!$conn ) {
        die ('Connect failed: '.mysqli_connect_error ());
    }

    $mail = $_POST['mail'];
    $pwd = $_POST['pwd'];  
    
    if (empty ($mail) || empty ($pwd)) {
        header ("Location: index.php?error=emptyfields&mail=".$mail."&phone".$phone."&loc".$loc);
        exit ();
    } else {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_stmt_init ($conn);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
            header ("Location: index.php?error=sqlerror");
            exit ();
        } else {
            mysqli_stmt_bind_param ($stmt, "s", $mail);
            mysqli_stmt_execute ($stmt);
            $result = mysqli_stmt_get_result ($stmt);
            if ($row = mysqli_fetch_assoc ($result)) {
                $pwdCheck = password_verify ($pwd, $row['pwd']);
                if ($pwdCheck == false) {
                    header ("Location: index.php?error=wrongpwd");
                    exit ();
                } else if ($pwdCheck == true) {
                    session_start ();
                    $_SESSION['uid'] = $row['uid'];
                    $_SESSION['email'] = $row['email'];
                    header ("Location: index.php?login=success");
                    exit ();
                } else {
                    header ("Location: index.php?error=wrongpwd");
                    exit ();
                }
            } else {
                header ("Location: index.php?error=nouser");
                exit ();
            }
        }
    }

    mysqli_stmt_close ($stmt);
    mysqli_close ($conn);
} else {
    header ("Location: index.php");
    exit ();
}
?>