<?php 
    require "header.php";
?>

<html>
    <head>
        <style>
            p {
                display: flex;
                align-items: center; 
                justify-content: center;
            }
            .h1-class {
                display: flex;
                align-items: center; 
                justify-content: center;
            }
        </style>
    </head>
    
    <main>
        <div class="h1-class">
            <h1>Add Contacts</h1>
        </div>
        <?php 
            if (isset ($_SESSION['uid'])) {
                echo '<form class="form-signin" action="create_contact.php" method="post">
                        <input type="text" class="form-control" name="firstName" placeholder="First Name...">
                        <input type="text" class="form-control" name="lastName" placeholder="Last Name...">
                        <input type="text" class="form-control" name="mail" placeholder="Email...">
                        <input type="number" name="phone" class="form-control" placeholder="Phone #...">
                        <button class="btn btn-lg btn-primary btn-block" type="submit" name="contact-submit">Add Contact</button>
                    </form>';
            } else {
                echo '<p>Please log in or sign up to add contacts.</p>';
            }
        ?>
    </main>
</html>
