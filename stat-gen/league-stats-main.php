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
        echo "No results in db.<br>";
        $conn->close();
    } else {
        // Get stat data
        $jsonData = $result->fetch_assoc();
        // If stats available call output function!
        GenerateOutput3(json_decode($jsonData["stat"]));
        $conn->close();
    }
} else {
    echo "Error mysql connection.";
}

/*
Function generating output!
*/
function GenerateOutput3($obj) {
    $output = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/stat-gen/heading.php');
    echo str_replace('{heading}','Main Stats',$output);
    echo "<div class=\"top-margin-1\"></div>";
    if (is_object($obj)) {
        //echo "<div class=\"list-stats indent2\">Players active in the last hour (Currently Online): <span>$obj->ActivePlayers</span></div>";
        echo "<div class=\"list-stats indent2\">Players active in the last hour (Currently Online): <span>n/a</span></div>";
        echo "<div class=\"list-stats indent2\">Number of players participating: <span>$obj->AccountsParticipating</span></div>";
        echo "<div class=\"list-stats indent2\">Total characters created: <span>$obj->TotalCharacters</span></div>";
        $deadPercentage = round($obj->DeadCharacters*10000/$obj->TotalCharacters)/100;
        echo "<div class=\"list-stats indent2\">Dead characters: <span>$obj->DeadCharacters ($deadPercentage%)</span></div>";
        $alivePercentage = round($obj->AliveCharacters*10000/$obj->TotalCharacters)/100;
        echo "<div class=\"list-stats indent2\">Alive characters: <span>$obj->AliveCharacters ($alivePercentage%)</span></div>";
        echo "<div class=\"list-stats indent2\">Alive characters above level 10: <span>$obj->CharsAliveAboveLvl10</span></div>";
        echo "<div class=\"list-stats indent2\">Alive characters above level 50: <span>$obj->CharsAliveAboveLvl50</span></div>";
            $DeadBeforeLvl10Percentage = round($obj->DeadBeforeLvl10*10000/$obj->TotalCharacters)/100;
        echo "<div class=\"list-stats indent2\">Died before reching level 10: <span>$obj->DeadBeforeLvl10 ($DeadBeforeLvl10Percentage%)</span></div>";
    } else {
        echo "<div class=\"list-stats indent2\">Nothing to show yet.</div>";
    }
}
?>