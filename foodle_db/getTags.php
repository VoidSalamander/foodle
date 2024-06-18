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

    // 查詢所有標籤
    $query = "SELECT name, type FROM tag";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $tags = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!isset($tags[$row['type']])) {
            $tags[$row['type']] = array();
        }
        $tags[$row['type']][] = $row['name'];
    }

    echo json_encode($tags);
} catch (Exception $e) {
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
}
?>
