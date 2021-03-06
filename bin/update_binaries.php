<?php

require(dirname(__FILE__)."/config.php");
require_once(WWW_DIR."/lib/groups.php");
require_once(WWW_DIR."/lib/binaries.php");
$time = TIME();

if (isset($argv[1]))
{
        $group = $argv[1];
        echo "Updating group {$group}\n";

        $g = new Groups;
        $group = $g->getByName($group);

        $bin = new Binaries;
        $bin->updateGroup(null, $group);
}
else
{
        $binaries = new Binaries;
        $binaries->updateAllGroups();
}

function relativeTime($_time) {
    $d[0] = array(1,"sec");
    $d[1] = array(60,"min");
    $d[2] = array(3600,"hr");
    $d[3] = array(86400,"day");
    $d[4] = array(31104000,"yr");

    $w = array();

    $return = "";
    $now = TIME();
    $diff = ($now-$_time);
    $secondsLeft = $diff;

    for($i=4;$i>-1;$i--)
    {
        $w[$i] = intval($secondsLeft/$d[$i][0]);
        $secondsLeft -= ($w[$i]*$d[$i][0]);
        if($w[$i]!=0)
        {
            //$return.= abs($w[$i]). " " . $d[$i][1] . (($w[$i]>1)?'s':'') ." ";
            $return.= $w[$i]. " " . $d[$i][1] . (($w[$i]>1)?'s':'') ." ";
        }
    }

    //$return .= ($diff>0)?"ago":"left";
    return $return;
}

echo "\n\033[1;33mStock binaries update process completed in: " .relativeTime($time). "\n";

?>

