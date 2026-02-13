<?php
require "db.php";

$year  = $_GET["year"] ?? date("Y");
$month = $_GET["month"] ?? date("m");
$category = $_GET["category"] ?? "all";

$sql = "
SELECT e.amount, e.expense_date, c.name AS category
FROM expenses e
JOIN categories c ON e.category_id = c.id
WHERE YEAR(e.expense_date) = ?
AND MONTH(e.expense_date) = ?
";

$params = [$year, $month];
$types = "ii";

if ($category !== "all") {
    $sql .= " AND c.name = ?";
    $params[] = $category;
    $types .= "s";
}

$sql .= " ORDER BY e.expense_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();

$total = 0;
$byCategory = [];
$items = [];

while ($row = $result->fetch_assoc()) {
    $amount = (float)$row["amount"];
    $total += $amount;

    $byCategory[$row["category"]] =
        ($byCategory[$row["category"]] ?? 0) + $amount;

    $items[] = $row;
}

echo json_encode([
    "total" => $total,
    "byCategory" => $byCategory,
    "items" => $items
]);
