<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
    
    <?php
      	$servername = "localhost";
        $username = "id17717023_snackconnection";
        $password = "6wLGQ3H.6wLGQ3H.";
        $dbname = "id17717023_snacktastic";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "
        SELECT User_ID
        FROM Users
        WHERE Username = '".$_POST['username']."' AND Password = '".$_POST['password']."'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) == 1)
        {
            $_SESSION['User_ID'] = mysqli_fetch_row($result)[0];
            $_SESSION['Snack_ID'] = -1;
            
            echo '<meta http-equiv = "refresh" content = "0; url = main.php"/>';
        } else if(mysqli_num_rows($result) == 0)
        {
            echo "
            <script type='text/javascript'>",
            "alert('Wrong username or password');",
            "</script>",
            "<meta http-equiv = 'refresh' content = '0; url = index.php'/>";
        } else
        {
            echo "
            <script type='text/javascript'>",
            "console.log('This should never happen');",
            "</script>";
        }
        mysqli_close($conn);
    ?>
    
</head>
<body>
    
</body>
</html>