<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("ngrok-skip-browser-warning: 69420");

include_once 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id)) {
    echo json_encode(array("message" => "Incomplete data."));
    exit();
}

$restaurant_id = htmlspecialchars(strip_tags($data->id));

try {
    $database = new Database();
    $db = $database->getConnection();
    
    $db->beginTransaction();
    
    $query = "DELETE FROM rest_tag WHERE rest_id = :restaurant_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':restaurant_id', $restaurant_id);
    if (!$stmt->execute()) {
        throw new Exception("Unable to delete related tags.");
    }
    
    $query = "DELETE FROM restaurant WHERE ID = :restaurant_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':restaurant_id', $restaurant_id);
    if (!$stmt->execute()) {
        throw new Exception("Unable to delete restaurant.");
    }
    
    $db->commit();
    
    echo json_encode(array("message" => "Restaurant deleted successfully."));
} catch (Exception $e) {
    // 回滾事務
    $db->rollBack();
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
}
?>
