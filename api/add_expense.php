<?php
require "db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (
    empty($data["amount"]) ||
    empty($data["category_id"]) ||
    empty($data["expense_date"])
) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ข้อมูลไม่ครบ"]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO expenses (amount, category_id, expense_date)
     VALUES (?, ?, ?)"
);
$stmt->bind_param(
    "dis",
    $data["amount"],
    $data["category_id"],
    $data["expense_date"]
);

echo json_encode(["success" => $stmt->execute()]);
