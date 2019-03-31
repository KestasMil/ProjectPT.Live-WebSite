<?php
/*
[ascendedClass] => 1 
[charClass] => Raider 
[totalChars] => 0 
[aliveChars] => 0 
[highestExperienceReached] => 0 
[highestLevelCurrentlyAlive] => 0 
[highestAliveAccountName] => 
[highestLevelReached] => 0
*/

// Include settings
include($_SERVER['DOCUMENT_ROOT']."/scripts/mysqlSettings.php");

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// If connection established output stats!
if (!$conn->connect_error) {
    $sql = "SELECT StatName, stat FROM stats WHERE StatName = 'ascendancy_by_popularity'";
    $result = $conn->query($sql);
    if($result->num_rows == 0) {
        // If no stat available just quit.
        $conn->close();
    } else {
        // Get stat data
        $jsonData = $result->fetch_assoc();
        // If stats available call output function!
        GenerateOutput(json_decode($jsonData["stat"]));
        $conn->close();
    }
}

/*
Function generating output!
*/
function GenerateOutput($obj) {
    $output = file_get_contents('heading.php');
    echo str_replace('{heading}','Ascendacy Classes',$output);
    foreach ($obj as $item) {
        if ($item->ascendedClass) {
            print($item->charClass . "<br>");
            print($item->totalChars . "<br>");
        }
    }
}
?>