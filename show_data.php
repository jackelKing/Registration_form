<?php
// show_data.php

$file = "registrations.txt";

echo "<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<title>All Registrations</title>
<style>
body {
    background-color: black;
    color: white;
    font-family: Arial, sans-serif;
    padding: 40px;
}
table {
    width: 80%;
    border-collapse: collapse;
    margin: auto;
}
th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
th {
    background-color: #444;
}
tr:nth-child(even) {
    background-color: #333;
}
a {
    color: #f0c674;
    text-decoration: none;
}
a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
<h2 style='text-align:center;'>All Registered Users</h2>
<a href='index.html'>⬅ Back to Registration Form</a><br><br>";

if (file_exists($file)) {
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (count($lines) > 0) {
        echo "<table><tr><th>Full Name</th><th>Email</th><th>Password</th><th>Age</th></tr>";
        foreach ($lines as $line) {
            // Split the data line into parts
            preg_match('/Full Name: (.*?) \| Email: (.*?) \| Password: (.*?) \| Age: (.*)/', $line, $matches);
            if (count($matches) === 5) {
                echo "<tr>
                        <td>{$matches[1]}</td>
                        <td>{$matches[2]}</td>
                        <td>{$matches[3]}</td>
                        <td>{$matches[4]}</td>
                      </tr>";
            }
        }
        echo "</table>";
    } else {
        echo "<p>No registrations yet.</p>";
    }
} else {
    echo "<p>No registrations file found.</p>";
}

echo "</body></html>";
?>
