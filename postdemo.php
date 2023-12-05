<?php
    include('config.php');

    date_default_timezone_set('Asia/Kolkata');
    $d = date("Y-m-d");
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