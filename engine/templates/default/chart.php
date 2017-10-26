<html>
<head>
    <style>
        body, * {
            padding: 0;
            margin: 0;
        }
        body {
            background: #333;
        }
        p {
            padding: 10px;
            font: 15px Tahoma;
            color: #fff;
            background: #fac795;
        }
    </style>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                [%mark1%],
                [%mark2%],
                [%mark3%],
                [%mark4%],
                [%mark5%]
            ], true);

            var options = {
                legend:'none',
                backgroundColor:"transparent",
                colors:['#fac795','pink'],
                hAxis:{
                    textStyle : {color:"#fff"},
                    gridlines : {color: "#fac795", count: 5}
                },
                vAxis: {
                    baselineColor : "#fff",
                    gridlines : {color:"#fff"},
                    textStyle : {color:"#fff"}
                },
                candlestick: {
                    risingColor : {fill:"transparent"},
                    fallingColor: {fill:"#fff"}
                }
            };

            var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    %content%
    <div id="chart_div" style="width: 350px; height: 150px;"></div>
</body>
</html>