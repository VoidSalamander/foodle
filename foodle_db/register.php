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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->username) && !empty($data->password) && !empty($data->email)) {
        $username = htmlspecialchars(strip_tags($data->username));
        $password = password_hash(htmlspecialchars(strip_tags($data->password)), PASSWORD_BCRYPT);
        $email = htmlspecialchars(strip_tags($data->email));

        $database = new Database();
        $db = $database->getConnection();

        $query = "INSERT INTO userdata (username, password, email, play_count, win_count) VALUES (:username, :password, :email, 0, 0)";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            echo json_encode(array("message" => "User was registered."));
        } else {
            echo json_encode(array("message" => "Unable to register the user."));
        }
    } else {
        echo json_encode(array("message" => "Incomplete data."));
    }
} else {
    echo json_encode(array("message" => "Invalid request method."));
}
?>
