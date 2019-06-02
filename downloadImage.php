<?php
// Connects to DB and downloades images.
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
    $sql          = "SELECT * FROM stete WHERE Registracija = '$registracija'";
    $result       = mysqli_query($link, $sql);
    
    if ($result->num_rows) {
        $storeArray = Array();
        while ($row = mysqli_fetch_array($result)) {
            $storeArray[] = $row['Slika'];
            $array        = array_values($storeArray);
        }
        $response["success"] = 1;
        $length              = count($array);
        for ($val = 0; $val < $length; $val++) {
            $response[$val] = $array[$val];
        }
        $data = json_encode($response);
        $data = str_replace("]]", "]", $data);
        $data = str_replace("[[", "[", $data);
        echo $data;
    } else {
        $response["success"] = 0;
        $response["img"]     = "nema slika";
        die(json_encode($response));
    }
}
?>