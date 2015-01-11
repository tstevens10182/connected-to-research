<?php
ini_set('display_errors', 'On');

/* Create file that creates connnection to database */
//include 'connection.php';

session_start();

$name_f = $_POST['name_f'];
$name_l = $_POST['name_l'];
$email = $_POST['email'];
$password = $_POST['password'];

$_SESSION['email'] = $email;

if ($_POST['name_f'] == "" || $_POST['name_f'] == null) {
    echo "Missing first name.";
    exit(0);
} 
if ($_POST['name_l'] == "" || $_POST['name_l'] == null) {
    echo "Missing last name.";
    exit(0);
}
if ($_POST['email'] == "" || $_POST['email'] == null) {
    echo "Missing email.";
    exit(0);
} 
if ($_POST['password'] == "" || $_POST['password'] == null) {
    echo "Missing password.";
    exit(0);
}

if (!($stmt = $mysqli->prepare("INSERT INTO User(name_f, name_l, email, password) VALUES (?, ?, ?, ?)"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param("ssss", $name_f, $name_l, $email, $password)) {
	echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
	if ($stmt->errno == 1062) {
		echo "This email already exists.";
	} else {
		echo "This account could not be registered.";
	}
	session_unset($_SESSION["email"]); 
	session_destroy(); 
} else {
	echo "success";
}
?>