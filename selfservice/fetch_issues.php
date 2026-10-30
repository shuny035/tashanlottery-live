<?php
header("Content-Type: application/json");

// Enable error reporting (Remove this in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("127.0.0.1", "root", "", "tashan_db");

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Input sanitization
$account_id = isset($_GET['account_id']) ? trim($_GET['account_id']) : null;
$issue_type = isset($_GET['issue_type']) ? trim($_GET['issue_type']) : null;

// Check if account_id is provided
if (empty($account_id)) {
    echo json_encode(["error" => "Account ID is required."]);
    exit;
}

// Prepare SQL query
$sql = "SELECT id, issue_type, withdrawal_amount, amount_deposit, status, created_at FROM issues WHERE account = ?";
$params = [$account_id];
$types = "s"; // 's' means string

if (!empty($issue_type)) {
    $sql .= " AND issue_type = ?";
    $params[] = $issue_type;
    $types .= "s"; // Adding another string type
}

$stmt = $conn->prepare($sql);

// Check if the statement prepared correctly
if (!$stmt) {
    echo json_encode(["error" => "SQL prepare error: " . $conn->error]);
    exit;
}

// Bind parameters dynamically
$stmt->bind_param($types, ...$params);

// Execute statement and check for errors
if (!$stmt->execute()) {
    echo json_encode(["error" => "SQL execution error: " . $stmt->error]);
    exit;
}

$result = $stmt->get_result();
$issues = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

// Return results as JSON
echo json_encode(["success" => true, "data" => $issues]);
?>
