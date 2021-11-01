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
        SELECT Password
        FROM Users
        WHERE User_ID = ".$_SESSION['User_ID'];
        $result = mysqli_query($conn, $sql);
        
        $row = mysqli_fetch_row($result);
        if($row[0] == $_POST['current'])
        {
            if($_POST['new'] == $_POST['repeat'])
            {
                $sql = "
                UPDATE Users
                SET Password = '".$_POST['new']."'
                WHERE User_ID = ".$_SESSION['User_ID'];
                $result = mysqli_query($conn, $sql);
            } else
            {
                echo "
                <script type='text/javascript'>",
                "alert('The new password is not the same as the repeated one');",
                "</script>";
            }
        } else
        {
            echo "
            <script type='text/javascript'>",
            "alert('Wrong password');",
            "</script>";
        }
        
        mysqli_close($conn);
    ?>
    <meta http-equiv = "refresh" content = "0; url = main.php"/>
</head>
<body>
    
</body>
</html>