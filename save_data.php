<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $age = htmlspecialchars($_POST["age"]);

    $data = "Full Name: $name | Email: $email | Password: $password | Age: $age\n";

    // Save to registrations.txt
    $file = fopen("registrations.txt", "a");
    fwrite($file, $data);
    fclose($file);

    echo "<h3>Registration Successful!</h3>";
    echo "<a href='show_data.php'>View All Registrations</a>";
}
?>
