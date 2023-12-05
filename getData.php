<?php
include('config.php');

$chartSql = "SELECT * FROM temperature_data ORDER BY id DESC LIMIT 20";
$chartResult = $conn->query($chartSql);

$chartData = array();
while ($chartRow = $chartResult->fetch_assoc()) {
    $chartData[] = $chartRow;
}

$tableSql = "SELECT * FROM temperature_data ORDER BY id DESC";
$tableResult = $conn->query($tableSql);

$tableData = array();
while ($tableRow = $tableResult->fetch_assoc()) {
    $tableData[] = $tableRow;
}

$conn->close();


$response = array(
    'chartData' => $chartData,
    'tableData' => $tableData
);

header('Content-Type: application/json');
echo json_encode($response);
?>