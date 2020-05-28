<?php
    session_start ();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <style type="text/css">
            .form-signin {
                width: 100%;
                max-width: 330px;
                padding: 15px;
                margin: 0 auto;
            }

            .create-account {
                width: 100%;
                text-align: center;
            }
        </style>

        <title> Covid-19 Tracker </title>
    </head>

    <body>
        <header>
            <nav>
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="navbar-brand" href="index.php">COVID-19 Tracker</a></li>
                        <li class="nav-item"><a class="nav-link" href="view-data.php">View Data</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact-us.php">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="add_contacts.php">Add My Contacts</a></li>
                    </ul>
                </nav>

                <div>
                    <?php 
                        if (isset ($_GET['error'])) {
                            if ($_GET['error'] == "emptyfields") {
                                echo '<p>Please fill in all fields.</p>';
                            } else if ($_GET['error'] == "nouser") {
                                echo '<p>This email is not registered.</p>';
                            } else if ($_GET['error'] == "wrongpwd") {
                                echo '<p>Incorrect password.</p>';
                            } 
                        } else if ($_GET['login'] == "success") {
                            echo '<p>Login successful!</p>';
                        }
                        if (isset ($_SESSION['uid'])) {
                            echo '<form action="logout.php" method="post">
                                  <button type="submit" name="logout-submit">Logout</button>
                                  </form>';
                        } else {
                            echo ' <form class="form-signin" action="login.php" method="post">
                                    <h1 class="h3 mb-3 font-weight-normal">Sign in or create an account.</h1>
                                    <label for="inputEmail" class="sr-only">Email address</label>
                                    <input type="text" class="form-control" name="mail" placeholder="Email..." required autofocus>
                                    <label for="inputPassword" class="sr-only">Password</label>
                                    <input type="password" class="form-control" name="pwd" placeholder="Password...">
                                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login-submit">Sign in</button>
                                   </form>
                                   <div class="create-account">
                                    <a href="signup.php">Create account</a>
                                   </div>';
                        }
                    ?>
                   

                    
                </div>
            </nav>
        </header>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
