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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array("message" => "Invalid request method."));
    exit();
}

$data = json_decode(file_get_contents("php://input"));

if (empty($data->username) || empty($data->password)) {
    echo json_encode(array("message" => "Incomplete data."));
    exit();
}

$username = htmlspecialchars(strip_tags($data->username));
$password = htmlspecialchars(strip_tags($data->password));

$database = new Database();
$db = $database->getConnection();

$query = "SELECT ID, password FROM userdata WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $username);

if (!$stmt->execute()) {
    echo json_encode(array("message" => "Unable to process the request."));
    exit();
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row || !password_verify($password, $row['password'])) {
    echo json_encode(array("message" => "Invalid username or password."));
    exit();
}

echo json_encode(array("message" => "Login successful.", "userID" => $row['ID'], "username" => $username));
?>
