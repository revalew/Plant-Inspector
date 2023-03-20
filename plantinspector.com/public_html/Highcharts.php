
        <script src="./Highcharts/code/highcharts.js"></script>
		<script src="./Highcharts/code/modules/series-label.js"></script>
		<script src="./Highcharts/code/modules/exporting.js"></script>
		<script src="./Highcharts/code/modules/offline-exporting.js"></script>
		<script src="./Highcharts/code/modules/export-data.js"></script>
		<script src="./Highcharts/code/modules/accessibility.js"></script>
		<script src="./js/canvas.js"></script>
		<script src="./html2canvas/html2canvas.js"></script>

		<script type="text/javascript">
			Highcharts.chart('container', {
				chart: {
					// height: 450,
					// type: 'line'
					height: (9 / 16 * 100) + '%' // 16:9 ratio
				},
				title: {
					text: 'Plant Inspector Temperature Graph'
				},

				subtitle: {
					//text: 'Source: <a href="#" target="_blank">.</a>'
				},

				yAxis: {
					title: {
						text: 'Temperature'
					}
				},

				xAxis: {
					type: 'datetime',
					categories: <?php echo $reading_time; ?>,
					accessibility: {
						rangeDescription: 'Range: <?php echo $readings_time[0]; ?> to <?php echo $readings_time[19]; ?>'
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
						}
						//pointStart:
					}
				},

				series: [{
					name: 'Temperature throughout the day',
					//data: array_column($sensor_data, 'sensorDataTemp')
					data: <?php echo $sensor_temp; ?>
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
				},
				legend: {enabled: false},
				credits: { enabled: false }

			});
		</script>
		
		<script type="text/javascript">
			
			Highcharts.chart('container2', {
				chart: {
					height: 64,
					type: 'line',
					marginBottom: 4
				},
				title: {
					text: ''
				},
				xAxis: {
					labels: {enabled: false},
					// offset: -3,
					lineWidth: 0,
					tickWidth: 0,
				},
				yAxis: {
					title: {
						text: ''
					},
					// gridLineColor: 'transparent',
					gridLineWidth: 1,
					labels: {
						align: 'left',
						x: -8,
						y: -1,
						style: {
							fontSize: 10
						}
					}
				},

				series: [{
					name: '',
					enableMouseTracking: false,
					data: <?php echo $sensor_temp; ?>
				}],

				responsive: {
					rules: [{
						condition: {
							maxWidth: 500
						},
					}]
				},
				
				navigation: {
					buttonOptions: {
						enabled: false
					}
				},
				legend: {enabled: false},
				credits: { enabled: false }

			});
			
		</script>