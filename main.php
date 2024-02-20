<?php
include(__DIR__ . '/bootstrap/app.php');
include 'includes/validlogin.inc.php';
$db = new mysql();

$is_yesterday = isset($_GET['yesterday']) && $_GET['yesterday'] == 1 ? true : false;
$emp_code = $_SESSION['emp_code'];
$date_for_attendance = date('Y-m-d'); // use as variable for quick test
// $date_now = date('Y-m-d',strtotime('2024-02-09')); // use as variable for quick test
if ($is_yesterday) {
	$date_for_attendance = date('Y-m-d', strtotime('-1 days')); // use as variable for quick test
}

$time_arr = [];

for ($i = 1; $i < 7; $i++) {
	$sql = '
		SELECT time 
		FROM vstaff_timesheet_integration 
		WHERE 1 
		AND action = "' . $i . '"
		AND emp_code = "' . $emp_code . '"
		AND date = "' . $date_for_attendance . '"
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


// to check yesterday timesheet 
$yesterday_date = date('Y-m-d', strtotime('-1 day'));
$sql_yesterday_clockout = "
  	SELECT * FROM vstaff_timesheet_integration 
	WHERE 
    `emp_code` = '$emp_code' AND
    `date` = '$yesterday_date'
";
$enable_back_to_yesterday = false; //FOR DEBUG, set to true if want to test yesterday
$yesterday_timesheet = $db->get($sql_yesterday_clockout);

// check is odd number, if yes, need clocked in, but not clocked out
$is_odd_number = count($yesterday_timesheet) % 2 != 0;
$is_pending_yesterday_timesheet = $is_odd_number;


// Variable for html use
$arr = ['First', 'Second', 'Third'];
?>


<?php
$tt = 'Clock In - vStaff';
include 'includes/vstaff_meta.php';
?>

<style>
	.control_button:disabled {
		color: grey !important;
		background: #d8d8d8 !important;
		cursor: not-allowed !important;
		-webkit-animation: pulsate 0s;
		animation: pulsate 0s;
		text-shadow: none;
		box-shadow: none;
	}
	.text_time {
		height: 70px;
		font-size: 14px;
		font-weight: bold;
	}
</style>
<div style="margin-left:28px; margin-right:28px;margin-top:20px;">
	<div class="my-3">
		<div style="display:inline-block;">
			<h1>My Attendance</h1>
		</div>
		<div style="display:inline-block;float:right;" class="noselect">
			<a class="btn btn-danger" href="logout.php">
				<i class="fa fa-sign-out fa-lg"></i> Sign Out
			</a>
		</div>
	</div>


	<?php if ($is_yesterday) { ?>
		<div style="background:#FDFFB0" class="rounded-lg rounded border my-3 p-2">
			<i class="fa fa-warning text-danger"></i> You are on <b>yesterday timesheet (<?=$date_for_attendance?>)</b> now.
			<?php if ($is_pending_yesterday_timesheet) { ?>
				<p class="p-2">
					<i class="fa fa-exclamation-triangle red"></i>
					Detected a pending Clock Out.
				</p>

			<?php } ?>
		</div>
	<?php } else if ($is_pending_yesterday_timesheet) { ?>
		<div style="background:#FDFFB0" class="rounded-lg rounded border my-3 p-2">
			<div class="text-center py-1">
				<i class="fa fa-2x fa-exclamation-triangle red"></i>
			</div>
			<p class="p-2">
				Detected a pending Clock Out from yesterday. You clocked in but have <b>not Clocked Out</b> yet.
				<br>
				If you are on <b>Night Shift</b>, please click the <a onclick="goToYesterday()" class="text-primary"><b><i class="fa fa-angle-left"></i> Yesterday</b></a> button and click Clock Out.
			</p>
		</div>
	<?php } ?>

	<div class="card">
		<div class="card-body">
			<legend style="font-size:1.5em;">
				<b>Attendance on <?= $date_for_attendance ?></b>

				<?php if ($is_yesterday) { ?>
					<button class="btn btn-sm btn-success border rounded" onclick="goToToday()"> <i class="fa fa-angle-down"></i> Today </button>
				<?php } else { ?>
					<button class="btn btn-sm btn-warning border rounded" onclick="goToYesterday()"> <i class="fa fa-angle-left"></i> Yesterday </button>
				<?php } ?>

			</legend>
			<table class="table table-borderless">
				<tbody class="fs-6">
					<tr>
						<td style="width:135px;">Employee</td>
						<td style="width:1px;">:</td>
						<td style="width:600px;"><?= $emp_code . ', ' . strtoupper($_SESSION['emp_name'])  ?></td>
					</tr>
					<tr>
						<td style="width:135px;">Company</td>
						<td style="width:1px;">:</td>
						<td style="width:600px;"><?= ENV::COMPANY_NAME ?></td>
					</tr>
					<tr>
						<td style="width:135px;">Branch</td>
						<td style="width:1px;">:</td>
						<td style="width:600px;"><?= ENV::COMPANY_BRANCH_CODE ?> - <?= ENV::COMPANY_BRANCH_NAME ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>


	<div>
		<div class="text-center mt-3" style="font-size:20px">
			<i class="far fa-clock"></i>
			Current Time <?= date("Y-m-d") ?> <b style="text-decoration:underline">
				<div id="clockDiv" style="display:inline;"></div>
			</b>
		</div>
		<div class="d-flex">

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
				<fieldset style="width:100%;padding:10px;margin:10px">
					<legend style="font-size:1.5em;"><b><?= $type ?></b></legend>
					</br>
					<div style="display:flex;justify-content:center">
						<table class="vstaff_table" style="text-align: center;">
							<thead>
								<tr>
									<td class="header" style="width:50%;font-size:15px">Time In</td>
									<td class="header" style="width:50%;font-size:15px">Time Out</td>
								</tr>
							</thead>
							<tbody>
								<tr class="rowcolor row_detail">
									<td class="text_time"><?= $time_in ?></td>
									<td class="text_time"><?= $time_out ?></td>
								</tr>
								<tr class="rowcolor row_detail">
									<td>
										<button onclick="time_in_func(<?= $seq_in ?>)" class="control_button" title="Click to apply time in." style="width:90px;" <?= $disabled_in ?>>
											<i class="fa fa-clock"></i> Clock In
										</button>
									</td>
									<td>
										<button onclick="time_in_func(<?= $seq_out ?>)" class="control_button" title="Click to apply time out." style="width:90px;" <?= $disabled_out ?>>
											<i class="fa fa-clock"></i> Clock Out
										</button>
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

<script>
	var IS_YESTERDAY = "<?= $is_yesterday ? 1 : 0 ?>";
	//make sure things don't start running until page DOM is ready for JS to execute
	$(document).ready(function() {


		//run displayTime function
		displayTime();
		//set interval to 1000ms (1s), so that info updates every second
		setInterval(displayTime, 1000);
	});

	//write function to display time
	function displayTime() {

		//define a variable for Date() object to store date/time information   
		var time = new Date();

		//define variables to store hours, minutes, and seconds
		//use Date object methods, i.e., getHours, getMinutes, getSeconds, to store desired info  
		var hours = time.getHours();
		var minutes = time.getMinutes();
		var seconds = time.getSeconds();

		//for 12hour clock, define a variable meridiem and default to ante meridiem (AM) 
		var meridiem = " AM";

		//since this is a 12 hour clock, once hours increase past 11, i.e., 12 -23, subtract 12 and set the meridiem
		//variable to post meridiem (PM) 
		if (hours > 11) {
			hours = hours - 12;
			meridiem = " PM";
		}

		//at 12PM, the above if statement is set to subtract 12, making the hours read 0. 
		//create a statement that sets the hours back to 12 whenever it's 0.
		if (hours === 0) {
			hours = 12;
		}

		//keep hours, seconds, and minutes at two digits all the time by adding a 0.
		if (hours < 10) {
			hours = "0" + hours;
		}

		if (minutes < 10) {
			minutes = "0" + minutes;
		}

		if (seconds < 10) {
			seconds = "0" + seconds;
		}

		//jquery to change text of clockDiv html element
		$("#clockDiv").text(hours + ":" + minutes + ":" + seconds + meridiem);

		//could also write this with vanilla JS as follows
		//var clock = document.getElesmentById('clockDiv');
		//clock.innerText = hours +":"+ minutes +":"+ seconds + meridiem;

	}

	async function time_in_func(id) {
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
			swalWarning('Invalid');
		} else {
			$.ajax({
				type: "POST",
				url: 'main_ajax.php',
				data: {
					"task": "time_in",
					"id": id,
					"is_yesterday": IS_YESTERDAY,
				},
				success: function(data) {
					let success_message = "";
					if (id == 1 || id == 3 || id == 5) {
						success_message = "Time in successfully";
					}
					if (id == 2 || id == 4 || id == 6) {
						success_message = "Time out successfully";
					}

					swalSuccess(success_message).then(res => {
						location.reload();
					})
				}
			});
		}
	}

	function goToYesterday() {
		location.href = "?yesterday=1";
	}

	function goToToday() {
		location.href = "?today=1";
	}
</script>