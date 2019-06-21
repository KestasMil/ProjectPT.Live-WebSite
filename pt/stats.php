<!DOCTYPE html>
<html lang="">

<head>
   <meta http-equiv="refresh" content="60">
    <script>
        // Nothing here

    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjectPT Live</title>
    <link rel="stylesheet" href="../fonts/stylesheet.css">
    <style>
        .stat-style {
            font-family: fontin_smallcapssmallcaps;
            color: #cac2a8;
            font-size: 1.46rem;
            margin-top: 0px;
        }

        .stat-small-style {
            font-family: fontinregular;
            font-style: italic;
            font-size: 14px;
            line-height: 1;
            color: #cac2a8;
        }

    </style>
</head>

<body>
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

    
// OUTPUT MAIN STATS
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
    }
} else {
    echo "Error mysql connection.";
}
    
// OUTPUT LEAD CHARACTER
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
Functions generating output!
*/
function GenerateOutput3($obj) {
    if (is_object($obj)) {
        echo "<div class=\"stat-style\">League Rips: <span>$obj->DeadCharacters</span></div>";
        echo "<div class=\"stat-small-style\">Reached level 10: <span>$obj->CharsAliveAboveLvl10</span></div>";
        echo "<div class=\"stat-small-style\">Reached level 50: <span>$obj->CharsAliveAboveLvl50</span></div>";    
    } else {
        echo "<div class=\"list-stats indent2\">Nothing to show yet.</div>";
    }
}
    
function GenerateOutput($obj) {
    if(is_array($obj)) {
//highest level acc
        $highestExp = 0;
            $highestLvl = 0;
            $accName = "";
        foreach ($obj as $item) {
                if ($item->aliveChars > 0) {
                    if($item->highestExperienceReached > $highestExp) {
                        $highestExp = $item->highestExperienceReached;
                        $highestLvl = $item->highestLevelCurrentlyAlive;
                        $accName = $item->highestAliveAccountName;
                    }
                }
        }
        echo "<div class=\"stat-small-style\">Account <span style=\"text-decoration:underline\">$accName</span> is leading at lvl <span>$highestLvl</span>.</div>";
//-----------------
    } else {
        echo "<div class=\"list-stats indent2\">Nothing to show yet.</div>";
    }
}
?>
</body>

</html>
