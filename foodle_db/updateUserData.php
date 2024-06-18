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

if(!empty($data->id) && !empty($data->currentPassword) && (!empty($data->newPassword) || !empty($data->username) || !empty($data->email))) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        // Verify current password
        $query = "SELECT password FROM userdata WHERE ID = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $data->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($data->currentPassword, $row['password'])) {
            // Update user data
            $updateQuery = "UPDATE userdata SET";
            $updateFields = [];
            $updateParams = [':id' => $data->id];

            if (!empty($data->username)) {
                $updateFields[] = "username = :username";
                $updateParams[':username'] = $data->username;
            }
            if (!empty($data->email)) {
                $updateFields[] = "email = :email";
                $updateParams[':email'] = $data->email;
            }
            if (!empty($data->newPassword)) {
                $updateFields[] = "password = :newPassword";
                $updateParams[':newPassword'] = password_hash($data->newPassword, PASSWORD_DEFAULT);
            }

            if (!empty($updateFields)) {
                $updateQuery .= " " . implode(", ", $updateFields) . " WHERE ID = :id";

                $updateStmt = $db->prepare($updateQuery);
                foreach ($updateParams as $param => $value) {
                    $updateStmt->bindValue($param, $value);
                }

                if ($updateStmt->execute()) {
                    echo json_encode(array("message" => "Update successful"));
                } else {
                    echo json_encode(array("message" => "Unable to update user data"));
                }
            } else {
                echo json_encode(array("message" => "No valid fields to update"));
            }
        } else {
            echo json_encode(array("message" => "Invalid current password"));
        }
    } catch (Exception $e) {
        echo json_encode(array("message" => "Error: " . $e->getMessage()));
    }
} else {
    echo json_encode(array("message" => "Incomplete data"));
}
?>
