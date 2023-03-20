<?php
	include_once "./header.php";

	$sql = "SELECT * FROM `sensorData` ORDER BY `sensorDataDate`";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
	        while ($row = mysqli_fetch_assoc($result)) {
        	        $sensor_data[] = $row;
	        }
	}






	$readings_time = array_column($sensor_data, 'sensorDataDate');
	$readings_time = array_reverse($readings_time);
	
	$sensor_temp = json_encode(array_column($sensor_data, 'sensorDataTemp'), JSON_NUMERIC_CHECK);
	$reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);








	if (isset($_GET["refresh"])){
		$refreshTime = $_GET["refresh"];
	} elseif (!file_exists("/var/www/plantinspector.com/public_html/python/stop-script")) {
	// no prevention of admin deleting the file -> it will think the sensorDataLogger program is running and will refresh the page
		$refreshTime = 10;	//TODO make it variable same as $_GET above ^
	} else {
		$refreshTime = 999999;
	}

	header("Refresh: $refreshTime; url = chart_ajax.php?refresh=$refreshTime#container");
?>
	<header class="header">
        <div class="hero-bg"></div>
        <div class="hero-text">
        	<h1>Inspector's<span> Charts</span></h1>
        </div>
    </header>

    <main>
        <div class="wrapper">

			<figure class="highcharts-figure">
				<div id="container"></div>
				<p class="highcharts-description">
					Basic line chart showing measurements of 1Wire Temperature sensor attached to the circut. The data used to create this chart can be seen below:
				</p>
			</figure>
			<div class="table-wrapper">

			<!-- style="flex:40%; max-width: 400px; margin: 0 5px" -->
				<table border="0" cellspacing="0" cellpadding="4">
					<tr>
						<td class="table_titles">ID</td>
						<td class="table_titles table-date">Date and Time</td>
						<td class="table_titles">Temperature</td>
					</tr>
					<?php

						// Retrieve all records and display them
						//$sql = "SELECT * FROM sensorData ORDER BY id DESC";
						$sql = "SELECT * FROM `sensorData` LIMIT 10";
						$result = mysqli_query($conn, $sql);

						// Used for row color toggle
						$oddrow = true;

						if (mysqli_num_rows($result) > 0) {
						// process every record
							while ($row = mysqli_fetch_assoc($result)) {
								if ($oddrow)
								{
									$css_class = ' class="table_cells_odd"';
									$css_date = ' class="table_cells_odd table-date"';
								}
								else
								{
									$css_class=' class="table_cells_even"';
									$css_date = ' class="table_cells_even table-date"';
								}

								$oddrow = !$oddrow;

								echo '<tr>';
								echo '   <td'.$css_class.'>'.$row["sensorDataId"].'</td>';
								// echo '   <td'.$css_date.'>'.$row["sensorDataDate"].'</td>';
								// echo '   <td'.$css_date.'>'.date("Y-m-d", strtotime($row["sensorDataDate"])).'<br>'.date("H:i:s", strtotime($row["sensorDataDate"])).'</td>';
								echo '   <td'.$css_date.'>'.date("Y-m-d\nH:i:s", strtotime($row["sensorDataDate"])).'</td>';
								echo '   <td'.$css_class.'>'.$row["sensorDataTemp"].'</td>';
								echo '</tr>';
							}
						}
					?>
				</table>

				<table border="0" cellspacing="0" cellpadding="4">
					<tr>
						<td class="table_titles">ID</td>
						<td class="table_titles">Date and Time</td>
						<td class="table_titles">Temperature</td>
					</tr>
					<?php

						// Retrieve all records and display them
						//$sql = "SELECT * FROM sensorData ORDER BY id DESC";
						$sql = "SELECT * FROM `sensorData` WHERE `sensorDataId` > 10 LIMIT 10";
						$result = mysqli_query($conn, $sql);

						// Used for row color toggle
						$oddrow = true;

						if (mysqli_num_rows($result) > 0) {
						// process every record
							while ($row = mysqli_fetch_assoc($result)) {
								if ($oddrow)
								{
									$css_class = ' class="table_cells_odd"';
									$css_date = ' class="table_cells_odd table-date"';
								}
								else
								{
									$css_class=' class="table_cells_even"';
									$css_date = ' class="table_cells_even table-date"';
								}

								$oddrow = !$oddrow;

								echo '<tr>';
								echo '   <td'.$css_class.'>'.$row["sensorDataId"].'</td>';
								echo '   <td'.$css_date.'>'.date("Y-m-d\nH:i:s", strtotime($row["sensorDataDate"])).'</td>';
								echo '   <td'.$css_class.'>'.$row["sensorDataTemp"].'</td>';
								echo '</tr>';
							}
						}
					?>
				</table>

			</div>

			<div class="data-logger">
				<h2>Start the program and update the table:</h2>
				<form action="http://plantinspector.com/add_data.php">
					<button type="submit" name="run">start logging data</button>
				</form>
				<form action="http://plantinspector.com/add_data.php" method="">
					<button type="submit" name="stop">stop logging data</button>
				</form>
			</div>

			<figure class="highcharts-figure2" style="opacity: 0; display: inline-block;">
				<div id="container2"></div>
			</figure>

			<div id="image" style="opacity: 0; display: inline-block;">
				<!-- <p>Image:</p> -->
			</div>

		</div>
	</main>
			<?php
				include './Highcharts.php';
			?>

<?php
	include_once './footer.php'
?>
