<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("ngrok-skip-browser-warning: 69420");

include_once 'db.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $query = "
        SELECT r.ID, r.rest_name, r.rest_info, r.address, r.is_chain_store, 
               GROUP_CONCAT(t.name SEPARATOR ',') as tags
        FROM restaurant r
        LEFT JOIN rest_tag rt ON r.ID = rt.rest_id
        LEFT JOIN tag t ON rt.tag_id = t.ID
        GROUP BY r.ID, r.rest_name, r.rest_info, r.address, r.is_chain_store
    ";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $restaurants = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $restaurant = array(
            "id" => $row['ID'],  // Include the ID here
            "name" => $row['rest_name'],
            "description" => $row['rest_info'],
            "address" => $row['address'],
            "isChain" => (bool) $row['is_chain_store'],
            "tags" => $row['tags'] ? explode(',', $row['tags']) : []
        );
        array_push($restaurants, $restaurant);
    }

    echo json_encode($restaurants);
} catch (Exception $e) {
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
}
?>
