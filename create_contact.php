<?php 
session_start ();

if (isset ($_POST['contact-submit'])) {
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
    
    if (empty ($fName) || empty ($lName) || empty ($mail) || empty ($phone)) {
        header ("Location: add_contacts.php?error=emptyfields&mail=".$mail."&phone".$phone);
        exit ();
    } else if (!filter_var ($mail, FILTER_VALIDATE_EMAIL)) {
        header ("Location: add_contacts.php?error=invalidmail&phone".$phone);
        exit ();
    } else {
        $sql = "SELECT * FROM users WHERE firstName=? AND lastName=?";
        $stmt = mysqli_stmt_init ($conn);
        if (!mysqli_stmt_prepare ($stmt, $sql)) {
            header ("Location: add_contacts.php?error=sqlerror");
            exit ();
        } else {
            mysqli_stmt_bind_param ($stmt, "ss", $fName, $lName);
            mysqli_stmt_execute ($stmt);
            $result = mysqli_stmt_get_result ($stmt);
            if ($row = mysqli_fetch_assoc ($result)) {
                $to_uid = $row['uid'];
            } else {
                $sql = "INSERT INTO users (firstName, lastName, email, phone, reg) VALUES (?, ?, ?, ?, 0);";
                $stmt = mysqli_stmt_init ($conn);
                if (!mysqli_stmt_prepare ($stmt, $sql)) {
                    header ("Location: add_contacts.php?error=sqlerror");
                    exit ();
                } else {
                    if (!mysqli_stmt_bind_param ($stmt, "sssi", $fName, $lName, $mail, $phone)) {
                        header ("Location: add_contacts.php?error=sqlerrorbind");
                        exit ();
                    }
                    if (!mysqli_stmt_execute ($stmt)) {
                        header ("Location: add_contacts.php?error=sqlerrorexe");
                        exit ();
                    }

                    $sql = "SELECT * FROM users WHERE firstName=? AND lastName=?";
                    $stmt = mysqli_stmt_init ($conn);
                    if (!mysqli_stmt_prepare ($stmt, $sql)) {
                        header ("Location: add_contacts.php?error=sqlerror");
                        exit ();
                    } else {
                        mysqli_stmt_bind_param ($stmt, "ss", $fName, $lName);
                        mysqli_stmt_execute ($stmt);
                        $result = mysqli_stmt_get_result ($stmt);
                        if ($row = mysqli_fetch_assoc ($result)) {
                            $to_uid = $row['uid'];
                        } else {
                            header ("Location: add_contacts.php?error=sqlerror");
                            exit ();
                        }
                    }
                }
            }
            $dbname = 'contacts';
            $conn = mysqli_connect ($dbhost, $dbuser, $dbpass, $dbname);
            $sql = "INSERT INTO contacts (from_uid, to_uid) VALUES (?, ?);";
            $stmt = mysqli_stmt_init ($conn);
            if (!mysqli_stmt_prepare ($stmt, $sql)) {
                header ("Location: add_contacts.php?error=sqlerror");
                exit ();
            } 
            if (!isset ($_SESSION['uid'])) {
                header ("Location: add_contacts.php?error=sessionerror");
                exit ();
            }
            $from_uid = $_SESSION['uid'];
            if (!mysqli_stmt_bind_param ($stmt, "ii", $from_uid, $to_uid)) {
                header ("Location: add_contacts.php?error=sqlerrorbind");
                exit ();
            }
            if (!mysqli_stmt_execute ($stmt)) {
                header ("Location: add_contacts.php?error=sqlerrorexe");
                exit ();
            }

            header ("Location: add_contacts.php?signup=success");
            exit ();
        }
    }

    mysqli_stmt_close ($stmt);
    mysqli_close ($conn);
} else {
    header ("Location: signup.php");
    exit ();
}
?>