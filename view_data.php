<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $db = new PDO('sqlite:' . __DIR__ . '/registrations.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $rows = $db->query("SELECT id, name, email, age, created_at FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

$logfile = __DIR__ . '/data.txt';
$logData = file_exists($logfile) ? file_get_contents($logfile) : "No data.txt file found yet.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Registered Users</title>
    <style>
        body {
            background-color: #111;
            color: #eee;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 30px;
        }
        table {
            border-collapse: collapse;
            width: 85%;
            margin: 20px auto;
            background-color: #222;
            box-shadow: 0 0 10px #444;
        }
        th, td {
            padding: 10px;
            border: 1px solid #555;
        }
        th {
            background-color: #333;
        }
        pre {
            text-align: left;
            background-color: #000;
            padding: 10px;
            width: 85%;
            margin: 20px auto;
            border-radius: 5px;
            overflow-x: auto;
        }
        a {
            color: #f0c674;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            color: white;
        }
    </style>
</head>
<body>
    <h2>📋 Registered Users (Database)</h2>
    <?php if (count($rows) === 0): ?>
        <p>No users yet.</p>
    <?php else: ?>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Age</th><th>Registered On</th></tr>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['id']) ?></td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['email']) ?></td>
                    <td><?= htmlspecialchars($r['age']) ?></td>
                    <td><?= htmlspecialchars($r['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <h2>📄 data.txt Log</h2>
    <pre><?= htmlspecialchars($logData) ?></pre>

    <p><a href="index.html">← Back to Form</a></p>
</body>
</html>
