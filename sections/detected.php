<div class="content_root">
    <div class="heading1">Accounts detected with multiple alive characters at the same time.</div>
    <?php
    // Include settings
include($_SERVER['DOCUMENT_ROOT']."/scripts/mysqlSettings.php");

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// If connection established output stats!
if (!$conn->connect_error) {
    $sql = "SELECT * FROM bannedaccounts ORDER BY LastDetected DESC";
    $result = $conn->query($sql);
    if($result->num_rows == 0) {
        // If no stat available just quit.
        $conn->close();
    } else {
        // Get stat data
        while($row = $result->fetch_assoc()) {
            echo "<div class=\"list-stats indent2\">Account Name: <span>$row[AccName]</span>. First Detected: <span>$row[FirstDetected]</span>. Last Detected: <span>$row[LastDetected]</span>. (<span>$row[Detections]</span>)</div>";
        }
        // If stats available call output function!
        
        $conn->close();
    }
}
    ?>
    <div class="text-content"></div>
</div>
