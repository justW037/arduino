<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@1.27.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@2.0.0"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <h1>Hệ thống theo dõi nhiệt độ.</h1>
    <div class="main">
        <canvas id="temperatureChart"></canvas>
    </div>
    <div id="temperatureTableContainer"></div>
    <script>
    var chartData;
    var labels;
    var temperatures;

    function updateData() {
        $.ajax({
            url: 'getData.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                chartData = data.chartData;
                labels = chartData[0].Timestamp;
                temperatures = chartData[0].temperature;
                console.log(labels);
                console.log(Date.now());
                var tableData = data.tableData;
                var tableHtml =
                    "<table id='c4ytable'><tr><th>id</th><th>Nhiệt độ</th><th>Thời gian</th></tr>";
                $.each(tableData, function(index, item) {
                    tableHtml += "<tr><td>" + item.id + "</td><td>" + item.temperature +
                        "</td><td>" + item.Timestamp + "</td></tr>";
                });
                tableHtml += "</table>";
                $('#temperatureTableContainer').html(tableHtml);
            },
            error: function(error) {
                console.log('Error fetching data: ' + error);
            }
        });
    }
    console.log(temperatures);
    var ctx = document.getElementById('temperatureChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Nhiệt độ đo được',
                data: [],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'realtime',
                    realtime: {
                        frameRate: 60,
                        onRefresh: function(chart) {
                            chart.data.datasets.forEach(function(dataset) {
                                dataset.data.push({
                                    x: Date.now(),
                                    y: temperatures
                                });
                            });
                        }
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Temperature (°C)'
                    }
                }
            }
        }
    });
    setInterval(updateData, 5000);
    updateData();
    </script>
</body>

</html>