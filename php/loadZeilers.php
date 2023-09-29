<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['role'] !== 'comite' && $_SESSION['role'] !== 'admin')) {
    // Redirect to a login page or show an access denied message
    header('Location: ../'); // Redirect to your login page
    exit(); // Make sure to exit to prevent further execution
}
// Include your database configuration file
require '../includes/config.php';

// Prepare the query to retrieve user data
$sql = "SELECT id, voornaam, achternaam, email, `role` FROM zeilers ORDER BY achternaam";
$result = $mysqli->query($sql);

// Create an array to store user data
$users = array();

// Fetch and process each row of data
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Close the database connection
$mysqli->close();

// Output the user data as JSON
header('Content-Type: application/json');
echo json_encode($users);
