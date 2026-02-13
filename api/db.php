<?php
header("Content-Type: application/json; charset=UTF-8");

$host = "sql204.infinityfree.com";
$user = "if0_41132062";
$pass = "L1atkge4mCNGZ5p";
$db   = "if0_41132062_expense";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}

$conn->set_charset("utf8");
