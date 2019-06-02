<?php
// Searches received username in DB and makes sure that login credentials are correct. 
// connecting to db
require_once __DIR__ . '/db_config.php';
$link = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

if(isset($_POST['username']) && isset($_POST['pass'])) {
	$username = $_POST['username'];
	$pass = $_POST['pass'];

	$options = [
	'salt' => "bac3478ae23ba3e6a45adc", 
	'cost' => 10 // the default cost is 10
	];

	$hash = password_hash($pass, PASSWORD_DEFAULT, $options);		

	$sql = "SELECT *FROM login WHERE user='".$username."' AND pass='".$pass."' LIMIT 1";		
	$result = mysqli_query($link,$sql);
	if ($result->num_rows) {
		 $response["success"] = 1;
		 $response["message"] = "Uspješan login!";
		die(json_encode($response));
	} else {
		$response["success"] = 0;
        $response["message"] = "Krivo korisničko ime ili lozinka!";
		die(json_encode($response));
	}	
}
mysqli_close($link);

?>