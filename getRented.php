<?php

// Connects to DB and gets array of all rented cars.
require_once __DIR__ . '/db_config.php';
$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
// get all cars from car table
$sql    = "SELECT *FROM auto_rented";
$result = mysqli_query($link, $sql);

// check for empty result
if ($result->num_rows) {
    $response[""] = array();
    while ($row = mysqli_fetch_array($result)) {
        $aut                 = array();
        $aut["registracija"] = $row[0];
        $aut["marka"]        = $row[1];
        $aut["model"]        = $row[2];
        $aut["km"]           = $row[3];
        $aut["stete"]        = $row[4];
        $aut["stanjeTanka"]  = $row[5];
        $aut["thumbimg"]     = $row[6];
        $aut["kategorija"]   = $row[7];
        array_push($response[""], $aut);
    }
    
    $data = json_encode(array_values($response));
    $data = str_replace("]]", "]", $data);
    $data = str_replace("[[", "[", $data);
    echo $data;
} else {
    $response["success"] = 0;
    $response["message"] = "No cars found";
    echo json_encode($response);
}
?>