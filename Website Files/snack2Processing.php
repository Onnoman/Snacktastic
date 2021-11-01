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
        
        $sql = "
        DELETE FROM SnackNames
        WHERE User_ID = ".$_SESSION['User_ID']." AND Snack_ID = ".$_POST['snackID'];
        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
    ?>
    <meta http-equiv = "refresh" content = "0; url = main.php"/>
</head>
<body>
    
</body>
</html>