<html>
   <head>
      <title>This is the title</title>
   </head>

   <body>
      <?php  

      echo 'IT WORKS'; 
      $dbhost = 'localhost';
      $dbuser = 'root';
      $dbpass = 'root';
      $conn = mysqli_connect ($dbhost, $dbuser, $dbpass);

      if(! $conn ) {
         die ('Connect failed');
      }
         
      echo 'Connected successfully';

      $result = mysqli_select_db ($conn, 'users');

      if (! $result) {
         die ('Open failed');
      }
      echo 'Selected testdb';

      $sql = "SELECT * FROM users";

      $records = mysqli_query ($conn, $sql);

      if (! $records) {
         die ('Query failed:');
      }

      echo 'Successful query';

      ?>
   </body>
</html>
