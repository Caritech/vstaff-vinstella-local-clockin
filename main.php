<?php
include "includes/mysql.class.php";
$db = new mysql();
$tt = 'Timesheet';
include 'includes/vstaffmeta.inc_latest.php';
include 'includes/validlogin.inc.php';
?>
<link type="image/x-icon" href="images/waffles_favicon.ico" rel="shortcut icon" />
<link type="text/css" href="includes/jquery-ui-1.11.4/jquery-ui-1.11.4/jquery-ui.css" rel="Stylesheet" />
<script type="text/javascript" src="includes/jquery-ui-1.11.4/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" src="includes/jquery-ui-1.11.4/jquery-ui-1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="includes/font-awesome/css/font-awesome.min.css">
<style>
	input[type=button]:disabled {
		color: grey !important;
		background: #d8d8d8 !important;
		cursor: not-allowed !important;
		-webkit-animation: pulsate 0s;
		animation: pulsate 0s;
		text-shadow: none;
		box-shadow: none;
	}
</style>

<?php

$date_now = date('Y-m-d'); // use as variable for quick test
// $date_now = date('Y-m-d',strtotime('2024-02-09')); // use as variable for quick test

$time_arr = [];

for ($i = 1; $i < 7; $i++) {
	$sql = '
	SELECT time 
	FROM vstaff_timesheet_integration 
	WHERE 1 
	AND action = "' . $i . '"
	AND emp_code = "' . $_SESSION['emp_code'] . '"
	AND date = "' . $date_now . '"
';
	$rs = $db->query($sql);
	list($time) = $rs->fetch_row();
	if (empty($time)) {
		$time = "";
		$disabled = "";
	} else {
		$disabled = "disabled";
	}

	if (in_array($i, [2, 4, 6])) {
		$prev_time = $time_arr[$i - 1]['time'];
		if (empty($prev_time)) $disabled = "disabled";
	}

	$time_arr[$i] = [
		'time' => $time,
		'disabled' => $disabled,
	];
}

// echo '<pre>';
// print_r($time_arr);
// echo '</pre>';

$arr = ['First', 'Second', 'Third'];

?>


<script>
	function clock() {
		//Save the times in variables
		var today = new Date();
		var hours = today.getHours();
		var minutes = today.getMinutes();
		var seconds = today.getSeconds();
		//Set the AM or PM time
		if (hours >= 12) {
			meridiem = " PM";
		} else {
			meridiem = " AM";
		}

		//convert hours to 12 hour format and put 0 in front
		if (hours > 12) {
			hours = hours - 12;
		} else if (hours === 0) {
			hours = 12;
		}
		//Put 0 in front of single digit minutes and seconds
		if (minutes < 10) {
			minutes = "0" + minutes;
		} else {
			minutes = minutes;
		}
		if (seconds < 10) {
			seconds = "0" + seconds;
		} else {
			seconds = seconds;
		}
		document.getElementById("clock").innerHTML = (hours + ":" + minutes + ":" + seconds + meridiem);
	}
	setInterval('clock()', 100);

	function time_in_func(id) {
		var today = new Date();
		var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
		//var today = $('#date').val();
		//var time = $('#time').val();
		var time_in_1 = $('#time_in_1').val();
		var time_in_2 = $('#time_in_2').val();
		var time_in_3 = $('#time_in_3').val();
		var time_in_4 = $('#time_in_4').val();
		var time_in_5 = $('#time_in_5').val();
		var time_in_6 = $('#time_in_6').val();

		var validate = '0';
		if (id == '6' && time_in_5 == "N/A") {
			validate = '1';
		}
		if (id == '5' && time_in_4 == "N/A") {
			validate = '1';
		}
		if (id == '4' && time_in_3 == "N/A") {
			validate = '1';
		}
		if (id == '3' && time_in_2 == "N/A") {
			validate = '1';
		}
		if (id == '2' && time_in_1 == "N/A") {
			validate = '1';
		}

		if (validate == '1') {
			swal({
				title: "Please fill up the required field(s)",
				type: "warning",
			}, function() {

			});
		} else {
			$.ajax({
				type: "POST",
				url: 'main_ajax.php',
				data: {
					"task": "time_in",
					"id": id,
					"today": today,
					"time": time,
				},
				success: function(data) {
					swal({
						title: "Time in successfully",
						text: "",
						type: "success",
						showCancelButton: false,
						confirmButtonColor: "#8cd4f5",
						confirmButtonText: "OK",
						showLoaderOnConfirm: true,
						closeOnConfirm: true
					}, function() {
						location.reload();
					});
				}
			});
		}
	}
</script>

<div id="dl">
	<div id="dl_rs"></div>
</div>
<div style="margin-left:28px; margin-right:28px;margin-top:20px;">
	<div>
		<div style="display:inline-block;">
			<h1>My Attendance</h1>
		</div>
		<div style="display:inline-block;float:right;" class="noselect">
			<a class="vs_Ha vs_3e vs_af vs_yb signout_btn c_btn" href="logout.php">
				<i class="fa fa-sign-out fa-lg"></i> Sign Out
			</a>
		</div>
	</div>
	</br>
	</br>
	<div id="display">
		<fieldset>
			<legend style="font-size:1.5em;">
				<b>Attendance on <?= $date_now ?></b>
			</legend>
			<table>
				<tbody>
					<tr>
						<td style="width:135px;">Employee</td>
						<td style="width:1px;">:</td>
						<td style="width:600px;"><?= $_SESSION['emp_code'] . ',' . strtoupper($_SESSION['emp_name'])  ?></td>
					</tr>
					<tr>
						<td style="width:135px;">Company</td>
						<td style="width:1px;">:</td>
						<td style="width:600px;">Vinstella Jewellery Sdn Bhd</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
		<div id="clock" style="font-size:30px; margin-top:20px;"></div>

		<div style="display:flex;justify-content:space-around;margin:20px 0px">

			<?php foreach ($arr as $key => $type) { ?>
				<?php
				$seq = $key * 2;
				$seq_in = $seq + 1;
				$seq_out = $seq + 2;
				$time_in = $time_arr[$seq_in]['time'];
				$time_out = $time_arr[$seq_out]['time'];
				$disabled_in = $time_arr[$seq_in]['disabled'];
				$disabled_out = $time_arr[$seq_out]['disabled'];
				?>
				<fieldset style="width:100%;padding:20px;margin:20px">
					<legend style="font-size:1.5em;"><b><?= $type ?></b></legend>
					</br>
					<div style="display:flex;justify-content:center">
						<table class="vstaff_table" style="text-align: center;">
							<thead>
								<tr>
									<td class="header">Time In</td>
									<td class="header">Time Out</td>
								</tr>
							</thead>
							<tbody>
								<tr class="rowcolor row_detail">
									<td style="height:50px;"><?= $time_in ?></td>
									<td style="height:50px;"><?= $time_out ?></td>
								</tr>
								<tr class="rowcolor row_detail">
									<td>
										<input type="button" onclick="time_in_func(<?= $seq_in ?>)" class="control_button" title="Click to apply time in." style="width:90px;" value="&#xf067;  Clock In" <?= $disabled_in ?>>
									</td>
									<td>
										<input type="button" onclick="time_in_func(<?= $seq_out ?>)" class="control_button" title="Click to apply time out." style="width:90px;" value="&#xf067;  Clock Out" <?= $disabled_out ?>>
									</td>

								</tr>
							</tbody>
						</table>
					</div>
				</fieldset>
			<?php } ?>


			<input type="hidden" name="time_in_1" id="time_in_1" value="' . $time_1 . '" />
			<input type="hidden" name="time_in_2" id="time_in_2" value="' . $time_2 . '" />
			<input type="hidden" name="time_in_3" id="time_in_3" value="' . $time_3 . '" />
			<input type="hidden" name="time_in_4" id="time_in_4" value="' . $time_4 . '" />
			<input type="hidden" name="time_in_5" id="time_in_5" value="' . $time_5 . '" />
			<input type="hidden" name="time_in_6" id="time_in_6" value="' . $time_6 . '" />



		</div>
	</div>
</div>