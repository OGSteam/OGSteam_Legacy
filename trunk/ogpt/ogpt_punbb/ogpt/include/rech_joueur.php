<?php
function galaxy_show_ranking_unique_player($player, $last = false)
{
    global $db;

    $ranking = array();

    $request = "select datadate, rank, points";
    $request .= " from " . ogspy_rank_player_points;
    $request .= " where player = '" . $player . "'";
    $request .= " order by datadate desc";
    $result = $db->query($request);
    while (list($datadate, $rank, $points) = $db->fetch_row($result)) {
        $ranking[$datadate]["general"] = array("rank" => $rank, "points" => $points);
        if ($last)
            break;
    }

    $request = "select datadate, rank, points";
    $request .= " from " . ogspy_rank_player_fleet;
    $request .= " where player = '" . $player . "'";
    $request .= " order by datadate desc";
    $result = $db->query($request);
    while (list($datadate, $rank, $points) = $db->fetch_row($result)) {
        $ranking[$datadate]["fleet"] = array("rank" => $rank, "points" => $points);
        if ($last)
            break;
    }

    $request = "select datadate, rank, points";
    $request .= " from " . ogspy_rank_player_research;
    $request .= " where player = '" . $player . "'";
    $request .= " order by datadate desc";
    $result = $db->query($request);
    while (list($datadate, $rank, $points) = $db->fetch_row($result)) {
        $ranking[$datadate]["research"] = array("rank" => $rank, "points" => $points);
        if ($last)
            break;
    }

    return $ranking;
}


function convNumber($number)
{

    global $db;


    return (number_format($number, 0, '.', ' '));

}

?>

