<?php
/// ogspy ogsteam.fr
function galaxy_show_ranking_unique_player($player, $last = false)
{
    global $db,$pun_config;;

    $ranking = array();

    $request = "select datadate, rank, points";
    $request .= " from ".$pun_config["ogspy_prefix"] ."rank_player_points";
    $request .= " where player = '" . $player . "'";
    $request .= " order by datadate desc";
    $result = $db->query($request);
    while (list($datadate, $rank, $points) = $db->fetch_row($result)) {
        $ranking[$datadate]["general"] = array("rank" => $rank, "points" => $points);
        if ($last)
            break;
    }

    $request = "select datadate, rank, points";
    $request .= " from ".$pun_config["ogspy_prefix"] ."rank_player_fleet";
    $request .= " where player = '" . $player . "'";
    $request .= " order by datadate desc";
    $result = $db->query($request);
    while (list($datadate, $rank, $points) = $db->fetch_row($result)) {
        $ranking[$datadate]["fleet"] = array("rank" => $rank, "points" => $points);
        if ($last)
            break;
    }

    $request = "select datadate, rank, points";
    $request .= " from ".$pun_config["ogspy_prefix"] ."rank_player_research";
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


/**
 * ogspy ogsteam.fr
 */
function galaxy_show_ranking_unique_ally($ally, $last = false)
{
    global $db,$pun_config;;

    $ranking = array();

    $request = "select datadate, rank, points, number_member, points_per_member";
    $request .= " from ".$pun_config["ogspy_prefix"] ."rank_ally_points";
    $request .= " where ally = '" . $ally . "'";
    $request .= " order by datadate desc";
    $result = $db->query($request);
    while (list($datadate, $rank, $points, $number_member, $points_per_member) = $db->
        fetch_row($result)) {
        $ranking[$datadate]["general"] = array("rank" => $rank, "points" => $points,
            "points_per_member" => $points_per_member);
        $ranking[$datadate]["number_member"] = $number_member;
        if ($last)
            break;
    }

    $request = "select datadate, rank, points, number_member, points_per_member";
    $request .= " from ".$pun_config["ogspy_prefix"] ."rank_ally_fleet";
    $request .= " where ally = '" . $ally . "'";
    $request .= " order by datadate desc";
    $result = $db->query($request);
    while (list($datadate, $rank, $points, $number_member, $points_per_member) = $db->
        fetch_row($result)) {
        $ranking[$datadate]["fleet"] = array("rank" => $rank, "points" => $points,
            "points_per_member" => $points_per_member);
        $ranking[$datadate]["number_member"] = $number_member;
        if ($last)
            break;
    }

    $request = "select datadate, rank, points, number_member, points_per_member";
    $request .= " from ".$pun_config["ogspy_prefix"] ."rank_ally_research";
    $request .= " where ally = '" . $ally . "'";
    $request .= " order by datadate desc";
    $result = $db->query($request);
    while (list($datadate, $rank, $points, $number_member, $points_per_member) = $db->
        fetch_row($result)) {
        $ranking[$datadate]["research"] = array("rank" => $rank, "points" => $points,
            "points_per_member" => $points_per_member);
        $ranking[$datadate]["number_member"] = $number_member;
        if ($last)
            break;
    }

    return $ranking;
}


?>

