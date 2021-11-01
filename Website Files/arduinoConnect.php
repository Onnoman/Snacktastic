<?php 
date_default_timezone_set('Europe/Amsterdam');
$ID = $_GET['Snack_ID'];
$Done = $_GET['Done'];

$servername = "localhost";
$username = "id17717023_snackconnection";
$password = "6wLGQ3H.6wLGQ3H.";
$dbname = "id17717023_snacktastic";

$conn = new mysqli($servername, $username, $password, $dbname);

$day = (date('w')+6)%7;

$sql = "
UPDATE SnackAgenda
SET Done = 0
WHERE Day <> ".$day;

$result = mysqli_query($conn, $sql);

for($i = 0; $i < 24; $i++)
{
    $sql = "
    SELECT *
    FROM SnackAgenda
    WHERE Snack_ID = '".$ID."' AND 
    Time LIKE '".$i.":%' 
    AND Day = ".$day."
    ORDER BY Time Asc";
    
    $result = mysqli_query($conn, $sql);
    
    while($row = mysqli_fetch_row($result))
    {
        $time = intval(substr($row[3], 0, -3), 10)*60 + intval(substr($row[3], -2), 10);
        $timeNow = date('G')*60 + date('i');
        if($row[6] == 0)
        {
            if($timeNow >= $time && $timeNow <= $time+5)
            {
                echo "1 ".$row[4]." ".$row[5];
                $sql = "
                UPDATE SnackAgenda
                SET Done = 1
                WHERE Agenda_ID = ".$row[0];
                $result = mysqli_query($conn, $sql);
            } else if($timeNow > $time+5)
            {
                $sql = "
                UPDATE SnackAgenda
                SET Done = 3
                WHERE Agenda_ID = ".$row[0];
                $result = mysqli_query($conn, $sql);
            }
            $i = 24;
            break;
        } else if($row[6] == 1)
        {
            if($timeNow >= $time && $timeNow <= $time+5)
            {
                if($Done == 1)
                {
                    $sql = "
                    UPDATE SnackAgenda
                    SET Done = 2
                    WHERE Agenda_ID = ".$row[0];
                    $result = mysqli_query($conn, $sql);
                }
            } else if($timeNow > $time+5)
            {
                $sql = "
                UPDATE SnackAgenda
                SET Done = 3
                WHERE Agenda_ID = ".$row[0];
                $result = mysqli_query($conn, $sql);
            }
            $i = 24;
            break;
        }
    } 
}

mysqli_close($conn);
?>