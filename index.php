<?php 
    require "header.php";
?>

<main>
    <?php 
        if (isset ($_SESSION['uid'])) {
            echo '<p>You are Logged In</p>';
        } 
    ?>
</main>
