<?php
//Creates new record as per request
    //Connect to database
    $servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "embedded";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

    //Get current date and time
    date_default_timezone_set('Asia/Kolkata');
    $d = date("Y-m-d");
    //echo " Date:".$d."<BR>";
    $t = date("H:i:s");

    if(!empty($_POST['temperature'])) {
        $temperature = $_POST['temperature']; 

        $sql = "INSERT INTO temperature_data (temperature, `Timestamp`) VALUES (?, NOW())";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("d", $temperature); 
    
        if ($stmt->execute()) {
            echo "OK";
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
    }
	$conn->close();
?>