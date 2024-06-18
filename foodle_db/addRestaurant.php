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
    // 檢查請求方法
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    $data = json_decode(file_get_contents("php://input"));

    // 檢查輸入數據是否完整
    if (empty($data->restaurantName) || empty($data->city) || empty($data->district) || empty($data->road) || empty($data->description)) {
        throw new Exception("Incomplete data.");
    }

    $restaurantName = htmlspecialchars(strip_tags($data->restaurantName));
    $city = htmlspecialchars(strip_tags($data->city));
    $district = htmlspecialchars(strip_tags($data->district));
    $road = htmlspecialchars(strip_tags($data->road));
    $description = htmlspecialchars(strip_tags($data->description));
    $isChain = !empty($data->isChain) ? 1 : 0;

    // 將標籤數據與類型名稱配對
    $tags = [
        'style' => $data->style ?? [],
        'food' => $data->food ?? [],
        'price' => $data->price ?? [],
        'time' => $data->time ?? [],
        'location' => $data->location ?? [],
        'other' => $data->other ?? [],
        'customTags' => $data->customTags ?? []
    ];

    $db = new Database();
    $conn = $db->getConnection();

    if (!$conn) {
        throw new Exception("Failed to connect to the database.");
    }

    // 開始數據庫事務
    $conn->beginTransaction();

    // 插入餐廳數據
    $stmt = $conn->prepare("INSERT INTO restaurant (rest_name, address, district, city, rest_info, is_chain_store, is_official) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $address = $road;  // 假設address等於路名
    $is_official = 1;  // 這裡假設所有餐廳都是官方認證的，根據需要修改
    $stmt->bindParam(1, $restaurantName);
    $stmt->bindParam(2, $address);
    $stmt->bindParam(3, $district);
    $stmt->bindParam(4, $city);
    $stmt->bindParam(5, $description);
    $stmt->bindParam(6, $isChain);
    $stmt->bindParam(7, $is_official);
    if (!$stmt->execute()) {
        throw new Exception("Failed to insert restaurant data.");
    }

    // 獲取剛插入的餐廳ID
    $restaurantId = $conn->lastInsertId();

    // 插入標籤數據並插入到rest_tag表
    $stmtSelectTag = $conn->prepare("SELECT ID FROM tag WHERE name = ? AND type = ?");
    $stmtInsertTag = $conn->prepare("INSERT INTO tag (name, type, tag_info) VALUES (?, ?, ?)");
    $stmtInsertRestTag = $conn->prepare("INSERT INTO rest_tag (rest_id, tag_id) VALUES (?, ?)");

    foreach ($tags as $type => $tagArray) {
        foreach ($tagArray as $tag) {
            // 檢查標籤是否存在
            $stmtSelectTag->bindParam(1, $tag);
            $stmtSelectTag->bindParam(2, $type);
            $stmtSelectTag->execute();
            $tagId = $stmtSelectTag->fetchColumn();

            // 如果標籤不存在，則插入新標籤
            if (!$tagId) {
                $tagInfo = "";  // 根據需要設置tag_info
                $stmtInsertTag->bindParam(1, $tag);
                $stmtInsertTag->bindParam(2, $type);
                $stmtInsertTag->bindParam(3, $tagInfo);
                if (!$stmtInsertTag->execute()) {
                    throw new Exception("Failed to insert tag data: $tag.");
                }
                $tagId = $conn->lastInsertId();
            }

            // 插入到rest_tag表
            $stmtInsertRestTag->bindParam(1, $restaurantId);
            $stmtInsertRestTag->bindParam(2, $tagId);
            if (!$stmtInsertRestTag->execute()) {
                throw new Exception("Failed to insert rest_tag data for tag: $tag.");
            }
        }
    }

    $conn->commit();
    echo json_encode(["message" => "Restaurant and tags added successfully"]);
} catch (Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode(["message" => "Error: " . $e->getMessage()]);
}
?>
