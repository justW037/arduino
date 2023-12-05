<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	$conn = new mysqli($servername, $username, $password);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "CREATE DATABASE embedded";
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully";
	} else {
	    echo "Error creating database: " . $conn->error;
	}

	$conn->close();

	echo "<br>";

	include('config.php');
	
	$sql = "CREATE TABLE temperature_data (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        temperature DECIMAL(5, 2),
        `Timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";

	if ($conn->query($sql) === TRUE) {
	    echo "Table logs created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}

	$conn->close();
?>