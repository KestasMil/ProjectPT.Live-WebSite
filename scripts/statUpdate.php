<?php
//Scripts security pin to prevent accidental data insertion.
$pincode = 7878123;

//MySql credentials.
include("mysqlSettings.php");

function isInDatabase($statName) {
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT StatName FROM stats WHERE StatName = '$statName'";
    $result = $conn->query($sql);
    if($result->num_rows == 0) {
        $conn->close();
        return false;
    } else {
        $conn->close();
        return true;
    }
}

function updateStat($statName, $statData) {
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "UPDATE wbeast_projectpt.stats SET stat = '$statData', last_updated = NOW() WHERE StatName = '$statName'";

    if ($conn->query($sql) === TRUE) {
        echo "Stats for \"$statName\" updated!<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

if (isset($_GET['jsonData']) && isset($_GET['StatName']) && isset($_GET['pin'])) {
    if ($_GET['pin'] == $pincode) {
        if (isInDatabase($_GET['StatName'])) {
            updateStat($_GET['StatName'], $_GET['jsonData']);
        } else {
            echo "Stat named \"$_GET[StatName]\" does not exist.";
        }
    } else {
        echo 'Access denied!<br>';
    }
} else {
    echo 'Access denied!<br>';
}
?>
