<?php 
if (isset ($_POST['signup-submit'])) {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'root';
    $dbname = 'users';
    $conn = mysqli_connect ($dbhost, $dbuser, $dbpass, $dbname);
    if(!$conn ) {
        die ('Connect failed: '.mysqli_connect_error ());
    }

    $fName = $_POST['firstName'];
    $lName = $_POST['lastName'];
    $mail = $_POST['mail'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pwd = $_POST['pwd'];  
    $pwd_rep = $_POST['pwd-repeat'];
    
    if (empty ($fName) || empty ($lName) || empty ($mail) || empty ($phone) || empty ($city) || empty ($state) || empty ($pwd) || empty ($pwd_rep)) {
        header ("Location: signup.php?error=emptyfields&firstName=".$fName."&lastName=".$lName."&mail=".$mail."&phone=".$phone."&city=".$city."&state=".$state);
        exit ();
    } else if (!filter_var ($mail, FILTER_VALIDATE_EMAIL)) {
        header ("Location: signup.php?error=invalidmail&firstName=".$fName."&lastName=".$lName."&phone=".$phone."&city=".$city."&state=".$state);
        exit ();
    } else if ($pwd !== $pwd_rep) {
        header ("Location: signup.php?error=passwordcheck&firstName=".$fName."&lastName=".$lName."&mail=".$mail."&phone=".$phone."&loc=".$loc);
        exit ();
    } else {
        $sql = "SELECT * FROM users WHERE firstName=? AND lastName=?";
        $stmt = mysqli_stmt_init ($conn);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
            header ("Location: signup.php?error=sqlerrorprepare");
            exit ();
        } else {
            mysqli_stmt_bind_param ($stmt, "ss", $fName, $lName);
            mysqli_stmt_execute ($stmt);
            $result = mysqli_stmt_get_result ($stmt);
            if ($row = mysqli_fetch_assoc ($result)) {
                if ($row['reg'] == 1) {
                    header ("Location: signup.php?error=usertaken&mail=".$mail);
                    exit ();
                } else {
                    $sql = "UPDATE users SET city=?, _state=?, pwd=?, reg=1 WHERE firstName=? AND lastName=?";
                    $stmt = mysqli_stmt_init ($conn);
                    if (!mysqli_stmt_prepare ($stmt, $sql)) {
                        header ("Location: signup.php?error=sqlerrorprepare");
                        exit ();
                    } else {
                        $pwdHash = password_hash ($pwd, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param ($stmt, "sssss", $city, $state, $pwdHash, $fName, $lName);
                        mysqli_stmt_execute ($stmt);
    
                        header ("Location: signup.php?signup=success");
                        exit ();
                    }
                }
            } else {
                $sql = "INSERT INTO users (firstName, lastName, email, phone, city, _state, pwd) VALUES (?, ?, ?, ?, ?, ?, ?);";
                $stmt = mysqli_stmt_init ($conn);
                if (!mysqli_stmt_prepare ($stmt, $sql)) {
                    header ("Location: signup.php?error=sqlerrorprepare");
                    exit ();
                } else {
                    $pwdHash = password_hash ($pwd, PASSWORD_DEFAULT);
                    if (!mysqli_stmt_bind_param ($stmt, "sssisss", $fName, $lName, $mail, $phone, $city, $state, $pwdHash)) {
                        header ("Location: signup.php?error=sqlerrorbind");
                        exit ();
                    }
                    if (!mysqli_stmt_execute ($stmt)) {
                        $true_sql = "INSERT INTO users (firstName, lastName, email, phone, city, _state, pwd) VALUES (".$fName.", ".$lName.", ".$mail.", ".$phone.", ".$city.", ".$state.", ".$pwdHash.");";
                        header ("Location: signup.php?error=sqlerrorexe".$true_sql);
                        exit ();
                    }

                    header ("Location: signup.php?signup=success");
                    exit ();
                }
            }
        }
    }

    mysqli_stmt_close ($stmt);
    mysqli_close ($conn);
} else {
    header ("Location: signup.php");
    exit ();
}
?>