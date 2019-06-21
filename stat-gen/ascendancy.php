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
    global $HOMEDIR;
    $output = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/stat-gen/heading.php');
    echo str_replace('{heading}','Ascendancy Classes',$output);
    echo "<div class=\"top-margin-1\"></div>";
    if(is_array($obj)) {
        //test
        foreach ($obj as $item) {
            if ($item->ascendedClass) {
                echo "<div class=\"list-stats indent2 underline1 top-margin-1\">Class Name: <span>$item->charClass</span></div>";
//https://www.pathofexile.com/account/view-profile/Geoglyph
                if ($item->aliveChars > 0) {
                echo "<div class=\"list-stats indent3\">Highest Level Character Currently Alive <span>$item->highestLevelCurrentlyAlive</span> owned by account <a href=\"https://www.pathofexile.com/account/view-profile/$item->highestAliveAccountName\" target=\"_blank\" class=\"text-content external-links-account\">$item->highestAliveAccountName</a></div>";
                }

                echo "<div class=\"list-stats indent3\">Total Character Count: <span>$item->totalChars</span></div>
                <div class=\"list-stats indent3\">Alive Characters: <span>$item->aliveChars</span></div>
                <div class=\"list-stats indent3\">Highest Level Reached (including dead characters): <span>$item->highestLevelReached</span></div>";
            }
        }
    } else {
        echo "<div class=\"list-stats indent2\">Nothing to show yet.</div>";
    }
}
?>
