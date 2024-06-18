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

if(!empty($data->userId) && isset($data->win)) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "UPDATE userdata SET play_count = play_count + 1";
        if ($data->win) {
            $query .= ", win_count = win_count + 1";
        }
        $query .= " WHERE ID = :id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $data->userId);

        if($stmt->execute()) {
            echo json_encode(array("message" => "User stats updated successfully."));
        } else {
            echo json_encode(array("message" => "Unable to update user stats."));
        }
    } catch (Exception $e) {
        echo json_encode(array("message" => "Error: " . $e->getMessage()));
    }
} else {
    echo json_encode(array("message" => "Incomplete data."));
}
?>
