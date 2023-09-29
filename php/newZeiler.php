<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['role'] !== 'comite' && $_SESSION['role'] !== 'admin')) {
    // Redirect to a login page or show an access denied message
    header('Location: ../'); // Redirect to your login page
    exit(); // Make sure to exit to prevent further execution
}
require '../includes/config.php';
$unixtime = time();
// check everything is filled in
if (
    empty($_POST["voornaam"])       ||
    empty($_POST["achternaam"])     ||
    empty($_POST["emailadres"])     ||
    empty($_POST["role"])
) {
    die("Niet alles is ingevuld");
}
// check its an email
if (!filter_var($_POST["emailadres"], FILTER_VALIDATE_EMAIL)) {
    die("Email is niet correct als adres");
}
$voornaam = $_POST['voornaam'];
$achternaam = $_POST['achternaam'];
$email = $_POST['emailadres'];
$role = $_POST['role'];
$voornaam = $mysqli->real_escape_string($voornaam);
$achternaam = $mysqli->real_escape_string($achternaam);
$email = $mysqli->real_escape_string($email);
$role = $mysqli->real_escape_string($role);
$email = strtolower($email);
$voornaam = ucwords(strtolower($voornaam));
$achternaam = ucwords(strtolower($achternaam));
if ($role != "zeiler" && $role != "comite") {
    die("Ging iets mis");
}
// cheching if email is already used in the table
$sql = "SELECT * FROM zeilers WHERE email = '$email'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    die("Dit emailadres is al in gebruik");
}
// making an unique ID for the user
do {
    $permitted_chars = '123456789';
    $ID = substr(str_shuffle($permitted_chars), 0, 9);
    $result = mysqli_query($mysqli, "SELECT id FROM zeilers WHERE id = '$ID'");
    $rows = mysqli_num_rows($result);
} while ($rows > 1);
// making an hash and password
$permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789-_~';
$hash = substr(str_shuffle($permitted_chars), 0, 255);
$permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789-_~';
$password = substr(str_shuffle($permitted_chars), 0, 255);
$passwordHashed = password_hash($password, PASSWORD_DEFAULT);
// inserting data into table users
$sqlZeiler = "INSERT INTO `zeilers` (`id`, `voornaam`, `achternaam`, `email`, `hash`, `password`, `hashDate`, `date`, `role`) VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?)";
if ($stmt = $mysqli->prepare($sqlZeiler)) {
    $stmt->bind_param('isssssiis', $ID, $voornaam, $achternaam, $email, $hash, $passwordHashed, $unixtime, $unixtime, $role);
    if ($stmt->execute()) {
        //echo "user added to table" . "<br>";
        echo $voornaam . " toegevoeg";
    } else {
        die("is mislukt");
    }
} else {
    die("zit een fout in de query: $mysqli->error");
}
// email to user
$to = $email;
$subject = "Dizebra Login";
$message = '
<!DOCTYPE html>
<html>
<head>
<style>
.knop{
    background-color: #2454A4;
    color: #fff;
    padding: 14px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 15px;
}
</style>
</head>
<body>
<h1>Dizebra login mail</h1>
<p>Deze mail is bedoelt voor: ' . $voornaam . '</p>
<p>Klik de knop hier onder om in te loggen bij dizebra, dit is bedoelt voor het opgeven van vrijwilligers taken in de wedstreid comite van de dizebra of zazebra.</p>
<a class="knop" href="https://dizebra.nl/php/login.php?IDu=' . $ID . '&h=' . $hash . '&p=' . $passwordHashed . '">Login</a>
<p>Deze mail is je manier om in te loggen. Ben je de mail op een later moment kwijt, vul je je E-mail in op de site en krijg je een nieuwe mail.<br>
Je kan een Vlag/ster aan de mail geven. Maar je krijgt makkelijk een nieuwe link.</p>
<p>Werkt de knop niet? kopieer de link hier onder en plak die in je browser(bijvoorbeeld: Google chrome, Edge, Safari).<br>
https://dizebra.nl/php/login.php?IDu=' . $ID . '&h=' . $hash . '&p=' . $passwordHashed . '</p>
</body>
</html>
';
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <noreply@dizebra.nl>' . "\r\n";
mail($to, $subject, $message, $headers);
