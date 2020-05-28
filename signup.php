<?php 
    require "header.php";
?>

<html>
    <head>
        <style>
            h1 {
                display: flex;
                align-items: center; 
                justify-content: center;
            }
        </style>
    </head>
    
    <main>
        <h1>Create Account</h1>
        <?php 
            if (isset ($_GET['error'])) {
                if ($_GET['error'] == "emptyfields") {
                    echo '<p>Please fill in all fields.</p>';
                } else if ($_GET['error'] == "invalidmail") {
                    echo '<p>Please enter valid email.</p>';
                } else if ($_GET['error'] == "passwordcheck") {
                    echo '<p>Please ensure passwords match.</p>';
                } else if ($_GET['error'] == "usertaken") {
                    echo '<p>Email already registered.</p>';
                }
            } else if ($_GET['signup'] == "success") {
                echo '<p>Signup successful!</p>';
            }
        ?>
        <form class="form-signin" action="create-user.php" method="post">
            <input type="text" class="form-control" name="firstName" placeholder="First Name...">
            <input type="text" class="form-control" name="lastName" placeholder="Last Name...">
            <input type="text" class="form-control" name="mail" placeholder="Email...">
            <input type="number" class="form-control" name="phone" placeholder="Phone #...">
            <input type="text" class="form-control" name="city" placeholder="City...">
            <input type="text" class="form-control" name="state" placeholder="State...">
            <input type="password" class="form-control" name="pwd" placeholder="Password...">
            <input type="password" class="form-control" name="pwd-repeat" placeholder="Repeat Password...">
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="signup-submit">Signup</button>
        </form>
    </main>
</html>
