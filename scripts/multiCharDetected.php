<?php
//Scripts security pin to prevent accidental data insertion.
$pincode = 7878123;

//MySql credentials.
include("mysqlSettings.php");

function isInDatabase($accName) {
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT AccName FROM bannedaccounts WHERE AccName = '$accName'";
    $result = $conn->query($sql);
    if($result->num_rows == 0) {
        $conn->close();
        return false;
    } else {
        $conn->close();
        return true;
    }
}

function increaseCount($accName) {
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "UPDATE bannedaccounts SET Detections = Detections + 1, LastDetected = NOW() WHERE AccName = '$accName'";

    if ($conn->query($sql) === TRUE) {
        echo "Detection count for \"$accName\" increased!<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

function addToDatabase($accName) {
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "INSERT INTO bannedaccounts (AccName, Detections)
    VALUES ('$accName', 1)";

    if ($conn->query($sql) === TRUE) {
        echo "New record for account \"$accName\" created successfully.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

if (isset($_GET['accounts']) && isset($_GET['pin'])) {
    if ($_GET['pin'] == $pincode) {
        $accounts = explode(",",$_GET['accounts']);
        foreach ($accounts as $value) {
            if (isInDatabase($value)) {
                echo "Account \"$value\" already axists.<br>";
                increaseCount($value);
            } else {
                echo "Adding account name \"$value\" to database.<br>";
                addToDatabase($value);
            }
            echo '<br>';
        }
    } else {
        echo 'Access denied!<br>';
    }
} else {
    echo 'Access denied!<br>';
}
?>
