<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'db.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    if (!$conn) {
        throw new Exception("Failed to connect to the database.");
    }

    // 隨機選擇一個餐廳
    $query = "
        SELECT r.ID as restaurant_id, r.rest_name
        FROM restaurant r
        ORDER BY RAND()
        LIMIT 1
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($restaurant) {
        $restaurantId = $restaurant['restaurant_id'];

        $query = "
            SELECT t.name as tag_name, t.tag_info
            FROM tag t
            JOIN rest_tag rt ON t.ID = rt.tag_id
            WHERE rt.rest_id = :restaurant_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':restaurant_id', $restaurantId);
        $stmt->execute();

        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(array(
            "restaurant_id" => $restaurant['restaurant_id'],
            "restaurant_name" => $restaurant['rest_name'],
            "tags" => $tags
        ));
    } else {
        throw new Exception("No data found.");
    }
} catch (Exception $e) {
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
}
?>
