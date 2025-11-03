<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Connect or create SQLite DB
    $db = new PDO('sqlite:' . __DIR__ . '/registrations.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if it doesn't exist
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

    // Collect POST data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $age = intval($_POST['age'] ?? 0);

    if (!$name || !$email || !$password || !$age) {
        die("<h3 style='color:red;'>❌ Please fill all fields properly.</h3>");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $db->prepare("INSERT INTO users (name, email, password, age) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $hashed_password, $age]);

    // Also append to data.txt
    $logfile = __DIR__ . '/data.txt';
    $entry = sprintf(
        "[%s]  Name: %s | Email: %s | Age: %d\n",
        date('Y-m-d H:i:s'),
        $name,
        $email,
        $age
    );

    // Create file if missing, make writable
    if (!file_exists($logfile)) {
        touch($logfile);
        chmod($logfile, 0666);
    }

    if (file_put_contents($logfile, $entry, FILE_APPEND | LOCK_EX) === false) {
        echo "<p style='color:orange;'>⚠️ Warning: could not write to data.txt</p>";
    }

    // Show success message
    echo "<h2 style='color:lightgreen;'>✅ Registration Successful!</h2>";
    echo "<p>Thank you, <strong>$name</strong>. Your details have been saved.</p>";
    echo "<p><a href='index.html'>← Back to form</a> | <a href='view_data.php'>View All Entries →</a></p>";

} catch (Exception $e) {
    echo "<h3 style='color:red;'>Error:</h3> " . htmlspecialchars($e->getMessage());
}
?>
