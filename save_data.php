<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $db = new PDO('sqlite:' . __DIR__ . '/registrations.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            password TEXT NOT NULL,
            age INTEGER NOT NULL,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $age = intval($_POST['age'] ?? 0);

    if (!$name || !$email || !$password || !$age) {
        die("<h3 style='color:red;'>Please fill all fields.</h3>");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO users (name, email, password, age) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $hashed_password, $age]);

    echo "<h2 style='color:lightgreen;'>✅ Registration Successful!</h2>";
    echo "<p>Thank you, <strong>$name</strong>. Your details have been stored safely.</p>";
    echo "<p><a href='index.html'>← Go Back</a> | <a href='view_data.php'>View All Entries →</a></p>";

} catch (Exception $e) {
    echo "<h3 style='color:red;'>Error:</h3> " . htmlspecialchars($e->getMessage());
}
?>
