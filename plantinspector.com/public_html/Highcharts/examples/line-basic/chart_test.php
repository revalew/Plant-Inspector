<?php
	include_once "connect.php";
	
	$sql = "SELECT * FROM sensorData ORDER BY sensorDataDate DESC";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
                $sensor_data[] = $row;
        }
	}
	$readings_time = array_column($sensor_data, 'sensorDataDate');
	$sensor_temp = json_encode(array_reverse(array_column($sensor_data, 'sensorDataTemp')), JSON_NUMERIC_CHECK);
	$reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);
	
	echo $sensor_temp;
	echo "<br>";
	echo $reading_time;
	echo "<br><br><br><br>";
	echo $readings_time[0];
	echo "<br>";
	echo $readings_time[19];

?>

<!-- 

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Highcharts Example</title>

		<style type="text/css">
			.highcharts-figure,
			.highcharts-data-table table {
				min-width: 360px;
				max-width: 800px;
				margin: 1em auto;
			}

			.highcharts-data-table table {
				font-family: Verdana, sans-serif;
				border-collapse: collapse;
				border: 1px solid #ebebeb;
				margin: 10px auto;
				text-align: center;
				width: 100%;
				max-width: 500px;
			}

			.highcharts-data-table caption {
				padding: 1em 0;
				font-size: 1.2em;
				color: #555;
			}

			.highcharts-data-table th {
				font-weight: 600;
				padding: 0.5em;
			}

			.highcharts-data-table td,
			.highcharts-data-table th,
			.highcharts-data-table caption {
				padding: 0.5em;
			}

			.highcharts-data-table thead tr,
			.highcharts-data-table tr:nth-child(even) {
				background: #f8f8f8;
			}

			.highcharts-data-table tr:hover {
				background: #f1f7ff;
			}

		</style>
	</head>
	<body>
		<script src="../../code/highcharts.js"></script>
		<script src="../../code/modules/series-label.js"></script>
		<script src="../../code/modules/exporting.js"></script>
		<script src="../../code/modules/export-data.js"></script>
		<script src="../../code/modules/accessibility.js"></script>

		<figure class="highcharts-figure">
			<div id="container"></div>
			<p class="highcharts-description">
				Basic line chart showing trends in a dataset. This chart includes the
				<code>series-label</code> module, which adds a label to each line for
				enhanced readability.
			</p>
		</figure>





		<script type="text/javascript">
			Highcharts.chart('container', {

				title: {
					text: 'Plant Inspector Temperature Graph'
				},

				subtitle: {
					text: 'Source: <a href="#" target="_blank">.</a>'
				},

				yAxis: {
					title: {
						text: 'Temperature'
					}
				},

				xAxis: {
					accessibility: {
						rangeDescription: 'Range: <?php echo $readings_time[0] ?> to <?php echo $readings_time[19] ?>'
					}
				},

				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle'
				},

				plotOptions: {
					series: {
						label: {
							connectorAllowed: false
						},
						pointStart: <?php echo $readings_time[0] ?>
					}
				},

				series: [{
					name: 'Temperature throughout the day',
					data: array_column($sensor_data, 'sensorDataTemp')
				}],

				responsive: {
					rules: [{
						condition: {
							maxWidth: 500
						},
						chartOptions: {
							legend: {
								layout: 'horizontal',
								align: 'center',
								verticalAlign: 'bottom'
							}
						}
					}]
				}

			});
		</script>
	</body>
</html>

-->
