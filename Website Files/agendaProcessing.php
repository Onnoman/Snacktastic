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
        $time = "";
        if($_POST['minutes']/10 < 1)
        {
            $time = $_POST['hour'].":0".$_POST['minutes'];
        } else
        {
            $time = $_POST['hour'].":".$_POST['minutes'];
        }
        $sql = "
        INSERT INTO SnackAgenda (Snack_ID, Day, Time, Buzz_Melody, LED_Color, Done)
        VALUES (".$_SESSION['Snack_ID'].", ".$_POST['day'].", '".$time."', ".$_POST['buzzMelody'].", '".$_POST['ledColor']."', 0)";
        
        echo "<script type='text/javascript'> alert('".$sql."') </script>";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
    ?>
    <meta http-equiv = "refresh" content = "0; url = main.php"/>
</head>
<body>
    
</body>
</html>