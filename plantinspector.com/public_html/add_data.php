<?php
	// Connect to MySQL
	include_once "./includes/dbh.inc.php";

	// Prepare the SQL statement
	/*
	date_default_timezone_set('Europe/Berlin');
	$dateS = date("Y-m-d H:i:s");
	echo $dateS;
	*/

	if (isset($_GET["temp"])) {
		$sql = "SELECT COUNT(`sensorDataTemp`) AS `dataPoints` FROM `sensorData`;";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$count = $row['dataPoints'];

		if ($count < 20) {
				$sql = "INSERT INTO `sensorData` (sensorDataDate, sensorDataTemp) VALUES (CURRENT_TIMESTAMP(), '".$_GET["temp"]."')";
		} else {
				// shift the entire table by 1 row up and "append" with new value as the new last value
				$sql = "UPDATE sensorData T1 JOIN sensorData T2 on T1.sensorDataId = T2.sensorDataId-1 SET T1.sensorDataDate = T2.sensorDataDate, T1.sensorDataTemp = T2.sensorDataTemp;";
				mysqli_query($conn, $sql);
				$sql = "UPDATE `sensorData` SET `sensorDataDate` = CURRENT_TIMESTAMP(), sensorDataTemp = '".$_GET["temp"]."' WHERE sensorDataId = 20;";
		}
		mysqli_query($conn, $sql);
	}


	if (isset($_POST["image"])) {

		// Get the incoming image data
		$image = $_POST["image"];

		// Remove image/jpeg from left side of image data
		// and get the remaining part
		$image = explode(";", $image)[1];

		// Remove base64 from left side of image data
		// and get the remaining part
		$image = explode(",", $image)[1];

		// Replace all spaces with plus sign (helpful for larger images)
		$image = str_replace(" ", "+", $image);

		// Convert back from base64
		$image = base64_decode($image);

		// Save the image as chart.png in img/ directory
		file_put_contents("img/chart.png", $image);

		// Sending response back to client
		//echo "Done";
	}

	if (isset($_GET["run"])) {
		shell_exec("rm -rf /var/www/plantinspector.com/public_html/python/stop-script");

		$command = escapeshellcmd("python /var/www/plantinspector.com/public_html/python/sensorDataLogger.py");
//		$command = escapeshellcmd("python /var/www/plantinspector.com/public_html/python/oled.py");

		$outputFile = '/dev/null';
		//$output = shell_exec($command);

//		echo shell_exec("/var/www/plantinspector.com/public_html/bash/start.sh 2>&1 &");
		//var_dump($output);

		$pidFile = shell_exec(sprintf("%s > %s 2>&1 & echo $!", $command, $outputFile));
		//echo shell_exec(sprintf("%s 2>&1", $command)); //testing python scripts

		// the solution proposed below does not work. pid = 0 all the time
		//$pidFile = 0;
		//shell_exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $command, $outputFile, $pidFile));

		//print_r($pidFile);
		//echo shell_exec(sprintf("ps %d", $pidFile));

		header("Location: chart_ajax.php?refresh=10");
	}
	if(isset($_GET["stop"])){
		//$command = escapeshellcmd('pkill -9 -f sensorDataLogger.py');
		//$output = shell_exec($command);
//		shell_exec("pkill -9 -f oled.py");
		shell_exec("touch /var/www/plantinspector.com/public_html/python/stop-script");

		// shell_exec('pkill -9 -f hello.py');
		header("Location: chart_ajax.php");
	}
