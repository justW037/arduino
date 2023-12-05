<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <canvas id="temperatureChart"></canvas>
    <div id="temperatureTableContainer"></div>
    <script>
    function updateData() {
        $.ajax({
            url: 'getData.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var chartData = data.chartData;
                var labels = chartData.map(item => item.Timestamp);
                var temperatures = chartData.map(item => item.temperature);
                myChart.data.labels = labels;
                myChart.data.datasets[0].data = temperatures;
                myChart.update();
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
                x: [{
                    type: 'time',
                    time: {
                        unit: 'day'
                    }
                }],
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