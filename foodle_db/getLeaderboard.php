<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'db.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    // 查詢排行榜
    $query = "SELECT username, play_count, win_count FROM userdata ORDER BY win_count DESC LIMIT 10";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $leaderboard = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $leaderboard[] = $row;
    }

    echo json_encode($leaderboard);
} catch (Exception $e) {
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
}
?>
