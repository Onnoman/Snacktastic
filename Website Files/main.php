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
</head>
<body onload="load()">
    <div class="container height">
        <div style="visibility: hidden" class="addAgenda" id="addAgenda">
            
        </div>
        <div style="visibility: hidden" class="buttonWindow" id="changePass">
            <div class="cross" onclick="stopPass()">×</div>
            <form method="post" action="passProcessing.php">
                Current password: <input type="password" name="current"><br>
                New password: <input type="password" name="new"><br>
                Repeat new password: <input type="password" name="repeat"><br>
                <input type="submit" value="Change">
            </form>
        </div>
        <div style="visibility: hidden; line-height: 7vh" class="buttonWindow" id="addSnackbox">
            <div class="cross" onclick="stopSnack()">×</div>
            Add Snackbox:<br>
            <form method="post" action="snackProcessing.php">
                Name: <input type="text" name="name"><br>
                ID: <input type="text" name="snackID"><br>
                <input type="submit" value="Add"><br>
            </form>
            Delete Snackbox:<br>
            <form method="post" action="snack2Processing.php">
                ID: <input type="text" name="snackID"><br>
                <input type="submit" value="Delete">
            </form>
        </div>
        <div class="row height">
            <div class="top col-16">
                Snack Tastic
            </div>
            <div class="row col-3">
                <div class="menu col-16 scrollContainer">
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
                        SELECT Snack_ID, Name
                        FROM SnackNames
                        WHERE User_ID = '".$_SESSION['User_ID']."'";
                        $result = mysqli_query($conn, $sql);
                        
                        while($row = mysqli_fetch_row($result))
                        {
                            $selected = "";
                            if($row[0] == $_SESSION['Snack_ID'])
                            {
                                $selected = 'style="background-color: gray"';
                            }
                            echo '
                            <form method="post" action="otherAgenda.php">
                            <input type="hidden" name="Snack_ID" value="'.$row[0].'">
                            <div '.$selected.' class="menuButton col-16" onclick="javascript:this.parentNode.submit()">
                                '.$row[1].' (ID: '.$row[0].')
                            </div>
                            </form>';
                        }
                    ?>
                </div>
                <div class="buttons col-8" onclick="changePass()">
                    Change password
                </div>
                <div class="buttons col-8" style="line-height: 4.5vh" onclick="addSnackbox()">
                    Add/Delete Snackbox
                </div>
            </div>
            <div class="row col-13">
                <div class="days col-2">
                    Time
                </div>
                <div class="days col-2">
                    Monday
                </div>
                <div class="days col-2">
                    Tuesday
                </div>
                <div class="days col-2">
                    Wednesday
                </div>
                <div class="days col-2">
                    Thursday
                </div>
                <div class="days col-2">
                    Friday
                </div>
                <div class="days col-2">
                    Saturday
                </div>
                <div class="days col-2">
                    Sunday
                </div>
            </div>
            <div class="row height col-13 scrollContainer" id="agenda">
                <?php 
                for($i = 0; $i < 24; $i++) {
                    echo '<div class="times height2 col-2">'
                    .$i.':00
                    </div>';
                    for($j = 0; $j < 7; $j++)
                    {
                        if($_SESSION['Snack_ID'] != -1)
                        {
                            $servername = "localhost";
                            $username = "id17717023_snackconnection";
                            $password = "6wLGQ3H.6wLGQ3H.";
                            $dbname = "id17717023_snacktastic";
                            
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
                            
                            $sql = "
                            SELECT *
                            FROM SnackAgenda
                            WHERE Snack_ID = '".$_SESSION['Snack_ID']."' AND 
                            Time LIKE '".$i.":%' 
                            AND Day = '".$j."'
                            ORDER BY Time Asc";
                            $result = mysqli_query($conn, $sql);
                            $div = 0;
                            if(mysqli_num_rows($result) > 0)
                            {
                                $div = 100/mysqli_num_rows($result);
                            }
                            echo '<div class="agenda col-2 height2" onclick="agendaAdd('.$i.','.$j.')">
                            <div class="inner">';
                            while($row = mysqli_fetch_row($result))
                            {
                                if($row[6] == 0)
                                {
                                    $color = 'white';
                                } else if($row[6] == 1)
                                {
                                    $color = 'yellow';
                                } else if($row[6] == 2)
                                {
                                    $color = 'green';
                                } else if($row[6] == 3)
                                {
                                    $color = 'red';
                                }
                                $melody = "";
                                if($row[4] == 1)
                                {
                                    $melody = "Melody 1";
                                } else if($row[4] == 2)
                                {
                                    $melody = "Melody 2";
                                } else if($row[4] == 3)
                                {
                                    $melody = "Melody 3";
                                } else if($row[4] == 4)
                                {
                                    $melody = "Melody 4";
                                }
                                echo '<div style="width: '.$div.'%; background-color: '.$color.'" class="inner2" onmouseover="extraInfo('.$row[0].')" onmouseout="stopExtraInfo('.$row[0].')">
                                '.$row[3].'
                                <div class="extraInfo" id="'.$row[0].'">
                                <a href="deleteProcessing.php?id='.$row[0].'"><div class="cross2">×</div></a>
                                Melody: <br> '.$melody.'<br>
                                LED-color: <br><div style="background-color: '.$row[5].'; color: '.$row[5].'; border-radius: 5px">.</div>
                                </div>
                                </div>';
                            }
                            echo '</div>
                            </div>';
                        } else
                        {
                            echo '<div class="agenda col-2 height2">
                        
                            </div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>