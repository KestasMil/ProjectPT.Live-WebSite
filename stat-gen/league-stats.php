<?php
/*
[AccountsParticipating] => 825 
[DeadAtLevel] => Array ( [0] => 0 [1] => 2418 [2] => 3647 [3] => 998 [4] => 317 [5] => 174 [6] => 154 [7] => 103 ...)
[TotalCharacters] => 10171 
[DeadCharacters] => 9758 
[AliveCharacters] => 413 
[CharsAliveAboveLvl10] => 212 
[CharsAliveAboveLvl50] => 29 
[DeadBeforeLvl10] => 8024
[accountableForMostDeaths] => Array ( [0] => stdClass Object ( [accName] => Lakonic_gamer [deaths] => 101 ) [1] => stdClass Object ( [accName] => brocell [deaths] => 97 ) ...)
*/

// Include settings
include($_SERVER['DOCUMENT_ROOT']."/scripts/mysqlSettings.php");

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// If connection established output stats!
if (!$conn->connect_error) {
    $sql = "SELECT StatName, stat FROM stats WHERE StatName = 'league_stats'";
    $result = $conn->query($sql);
    if($result->num_rows == 0) {
        // If no stat available just quit.
        $conn->close();
    } else {
        // Get stat data
        $jsonData = $result->fetch_assoc();
        // If stats available call output function!
        GenerateOutput2(json_decode($jsonData["stat"]));
        $conn->close();
    }
}

/*
Function generating output!
*/
function GenerateOutput2($obj) {
    // Dead at Level
    $output = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/stat-gen/heading.php');
    echo str_replace('{heading}','Number Of Deaths At All Levels',$output);
    echo "<div class=\"top-margin-1\"></div>";
    if(is_object($obj)) {
        for ($i = 1; $i <= 100; $i++) {
            if ($obj->DeadAtLevel[$i] > 0) {
                $numDeaths = $obj->DeadAtLevel[$i];
                echo "<div class=\"list-stats indent2\">Level: <span>$i</span> Deaths: <span>$numDeaths</span></div>";
            }
        }
    } else {
        echo "<div class=\"list-stats indent2\">Nothing to show yet.</div>";
    }
    // Accountable for most deaths
    $output = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/stat-gen/heading.php');
    echo str_replace('{heading}','Accountable For Most Deaths',$output);
    echo "<div class=\"top-margin-1\"></div>";
    if(is_object($obj)) {
        foreach ($obj->accountableForMostDeaths as $item) {
            echo "<div class=\"list-stats indent2\">Account Name: <span>$item->accName</span> Deaths: <span>$item->deaths</span></div>";
        }
    } else {
        echo "<div class=\"list-stats indent2\">Nothing to show yet.</div>";
    }
}
?>