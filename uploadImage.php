<?php

// Connects to DB and uploads pictures to damage report.
$name         = $_POST["name"];
$image        = $_POST["image"];
$registracija = $_POST["registracija"];
// connecting to db
require_once __DIR__ . '/db_config.php';
$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$sql    = "INSERT INTO stete(Registracija,Slika,Name) VALUES('$registracija','$image','$name')";
$result = mysqli_query($link, $sql);

if ($result) {
    // successfully updated
    $response["success"] = 1;
    $response["message"] = "Pic sent";
    echo json_encode($response);
} else {
    $response["success"] = 0;
    $response["message"] = "Oops! An error occurred.";
    echo json_encode($response);
}
?>