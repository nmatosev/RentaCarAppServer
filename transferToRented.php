<?php

// Sends the car from table of available cars to the rented cars table.
$response = array();
require_once __DIR__ . '/db_config.php';
// connecting to db
$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
if (isset($_POST['registracija'])) {
    $registracija = $_POST['registracija'];
    $marka        = $_POST['marka'];
    $model        = $_POST['model'];
    $kilometraza  = $_POST['kilometraza'];
    $stete        = $_POST['stete'];
    $tank         = $_POST['tank'];
    $thumbimg     = $_POST['thumbimg'];
    $kategorija   = $_POST['kategorija'];
    
    $sql       = "INSERT INTO auto_rented(Registracija,Marka,Model,Tank,Stete,Kilometraza,thumbimg,kategorija) VALUES('$registracija','$marka','$model','$tank','$stete','$kilometraza','$thumbimg','$kategorija')";
    $result    = mysqli_query($link, $sql);
    $sqlDel    = "DELETE FROM auto WHERE Registracija = '$registracija'";
    $resultDel = mysqli_query($link, $sqlDel);
    
    // check if row inserted or not
    if ($result) {
        $response["success"] = 1;
        $response["message"] = "auto successfully updated.";
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
        echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
    // echoing JSON response
    echo json_encode($response);
}
?>