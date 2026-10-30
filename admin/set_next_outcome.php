<?php
// admin/set_next_outcome.php
// Simple admin page to manually set the next winning number for the game.
// Access: /admin/set_next_outcome.php (or corresponding port for other sites)

// Basic auth for quick protection (replace with your own mechanism)
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Admin Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentication required.';
    exit;
}
// NOTE: In production replace the below credentials with a proper user store.
$validUser = 'admin';
$validPass = 'password';
if ($_SERVER['PHP_AUTH_USER'] !== $validUser || $_SERVER['PHP_AUTH_PW'] !== $validPass) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Invalid credentials.';
    exit;
}

require_once __DIR__.'/../config.php'; // assumes you have DB connection $conn here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num = intval($_POST['next_number'] ?? -1);
    if ($num < 0 || $num > 9) {
        $msg = 'Please enter a number between 0 and 9.';
    } else {
        // Upsert into gelluonduhogu_zehn_zehn_1 (id=1) the manual_number field
        $stmt = $conn->prepare('REPLACE INTO gelluonduhogu_zehn_zehn_1 (id, manual_number) VALUES (1, ?)');
        $stmt->bind_param('i', $num);
        $stmt->execute();
        $msg = "Next winning number set to $num.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Set Next Outcome</title></head>
<body>
<h1>Set Next Winning Number</h1>
<?php if (!empty($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="post">
    <label for="next_number">Number (0‑9): </label>
    <input type="number" id="next_number" name="next_number" min="0" max="9" required>
    <button type="submit">Save</button>
</form>
<p>After setting, the next game round will use this number as the winning outcome.</p>
</body>
</html>
