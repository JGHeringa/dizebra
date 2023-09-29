<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['role'] !== 'comite' && $_SESSION['role'] !== 'admin')) {
    // Redirect to a login page or show an access denied message
    header('Location: ../'); // Redirect to your login page
    exit(); // Make sure to exit to prevent further execution
}
require '../includes/config.php';
if (
    empty($_POST["datum"])       ||
    empty($_POST["zeilerid"])
) {
    die("Niet alles is ingevuld");
}
$datum = $_POST['datum'];
$zeilerid = $_POST['zeilerid'];
$datum = $mysqli->real_escape_string($datum);
$zeilerid = $mysqli->real_escape_string($zeilerid);

do {
    $permitted_chars = '123456789';
    $ID = substr(str_shuffle($permitted_chars), 0, 9);
    $result = mysqli_query($mysqli, "SELECT id FROM wedstreiden WHERE id = '$ID'");
    $rows = mysqli_num_rows($result);
} while ($rows > 1);

// inserting data into table users
$sqlZeiler = "INSERT INTO `wedstreiden` (`id`, `datum`, `zeiler-id`) VALUES  (?, ?, ?)";
if ($stmt = $mysqli->prepare($sqlZeiler)) {
    $stmt->bind_param('isi', $ID, $datum, $zeilerid);
    if ($stmt->execute()) {
        //echo "user added to table" . "<br>";
        echo $datum . " toegevoeg";
    } else {
        die("is mislukt");
    }
} else {
    die("zit een fout in de query: $mysqli->error");
}
