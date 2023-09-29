<?php
require '../includes/config.php';
$today = date("Y-m-d H:i:s");

$IDu = $_GET['IDu'];
$hash = $_GET['h'];
$password = $_GET['p'];

$IDu = $mysqli->real_escape_string($IDu);
$hash = $mysqli->real_escape_string($hash);
$password = $mysqli->real_escape_string($password);

$sql = "SELECT * FROM zeilers WHERE id=? AND `hash`=? AND `password`=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('iss', $IDu, $hash, $password);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // Fetch data as an associative array

if ($user) {
    session_start();
    $_SESSION['id'] = $user['id'];
    $_SESSION['voornaam'] = $user['voornaam'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['loggedIn'] = $today;
    header('Location: ../');
    // Access the 'id' column from the fetched data
    // You can access other columns similarly, e.g., $user['column_name']
} else {
    echo "User not found or invalid credentials.";
}

$stmt->close();
