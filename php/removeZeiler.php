<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['role'] !== 'comite' && $_SESSION['role'] !== 'admin')) {
    // Redirect to a login page or show an access denied message
    header('Location: ../'); // Redirect to your login page
    exit(); // Make sure to exit to prevent further execution
}
require '../includes/config.php';
if (
    empty($_POST["id"])         ||
    empty($_POST["achternaam"])
) {
    die("Niet alles is ingevuld");
}
$id = $_POST['id'];
$achternaam = $_POST['achternaam'];
$id = $mysqli->real_escape_string($id);
$achternaam = $mysqli->real_escape_string($achternaam);
// cheching if the user exist
$sql = "SELECT * FROM zeilers WHERE id = '$id' AND achternaam = '$achternaam'";
$result = $mysqli->query($sql);
if ($result->num_rows == 0) {
    die("Zeiler is niet bekend!");
}

// Fetch the user's data
$userData = $result->fetch_assoc();
$userRole = $userData['role']; // Assuming 'role' is the name of the column for the user's role

if ($userRole === 'admin') {
    die("500");
}

$sqlZeiler = "DELETE FROM `zeilers` WHERE  id = ? AND achternaam = ?";
if ($stmt = $mysqli->prepare($sqlZeiler)) {
    $stmt->bind_param('is', $id, $achternaam);
    if ($stmt->execute()) {
        //echo "user added to table" . "<br>";
        echo "400";
    } else {
        die("is mislukt");
    }
} else {
    die("zit een fout in de query: $mysqli->error");
}
