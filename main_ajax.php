<?php
include "includes/mysql.class.php";
$db = new mysql();
date_default_timezone_set('Asia/Singapore');
$tt = 'Timesheet';
$branch = '';
if($_POST['task'] == 'time_in'){
	$sql = '
	INSERT INTO vstaff_timesheet_integration(	
		emp_code,emp_name,date,time,branch,created_at,action
	)VALUES (
		"'.$_SESSION['emp_code'].'","'.$_SESSION['emp_name'].'",now(),CURRENT_TIMESTAMP,"'.$branch.'",CURRENT_TIMESTAMP,'.$_POST['id'].'
	)
	';
	/*
	$sql = '
	INSERT INTO vstaff_timesheet_integration(	
		emp_code,emp_name,date,time,branch,created_at,action
	)VALUES (
		"'.$_SESSION['emp_code'].'","'.$_SESSION['emp_name'].'","'.$_POST['today'].'","'.$_POST['time'].'","'.$branch.'",CURRENT_TIMESTAMP,'.$_POST['id'].'
	)
	';
	*/
	//echo $sql;
	$db->query($sql);
}

if($_POST['task'] == 'display'){
	for($i=1; $i<7; $i++){
		${'sql'.$i}='
			SELECT time 
			FROM vstaff_timesheet_integration 
			WHERE 1 
			AND action = "'.$i.'"
			AND emp_code = "'.$_SESSION['emp_code'].'"
			AND date = "'.date('Y-m-d').'"
		';
		${'rs'.$i} = $db->query(${'sql'.$i});
		list(${'time_'.$i}) = ${'rs'.$i}->fetch_row();
		if(${'time_'.$i} == ""){
			${'time_'.$i} = "N/A";
			${'disabled_'.$i} = "";
		}else{
			${'disabled_'.$i} = "disabled";
		}
	}
	if($time_1 != "N/A"){
		$disabled_1 = "disabled";
	}
	if($time_2 != "N/A"){
		$disabled_2 = "disabled";
	}
	if($time_3 != "N/A"){
		$disabled_3 = "disabled";
	}
	if($time_4 != "N/A"){
		$disabled_4 = "disabled";
	}
	if($time_5 != "N/A"){
		$disabled_5 = "disabled";
	}
	if($time_6 != "N/A"){
		$disabled_6 = "disabled";
	}
	echo '
		<fieldset>
			<legend style="font-size:1.5em;">
				<b>Attendance on '.date("Y-m-d").'</b>
			</legend>
			<table>
				<tbody>
					<tr>
						<td style="width:135px;">Employee</td>
						<td style="width:1px;">:</td>
						<td style="width:600px;">'.$_SESSION['emp_code'].','.strtoupper($_SESSION['emp_name']).'</td>
					</tr>
					<tr>
						<td style="width:135px;">Company</td>
						<td style="width:1px;">:</td>
						<td style="width:600px;">Vinstella Jewellery Sdn Bhd</td>
					</tr>
				</tbody>
			</table>
		</fieldset/>
		<div id="clock" style="font-size:30px; margin-top:20px;"></div>
		<div style="clear: both;margin-top:20px;" >
			<fieldset style="width: 378px; display:inline-block;">
			<legend style="font-size:1.5em;"><b>First</b></legend>
				</br>
				<div style="width:8%; float:left;margin-left:75px; margin-bottom:30px;">
					<table class="vstaff_table" style="text-align: center;">
						<thead>
							<tr>
								<td class="header">Time In</td>
							</tr>
						</thead>
						<tbody>
							<tr class="rowcolor row_detail">
								<td>'.$time_1.'</td>
							</tr>
							<tr class="rowcolor row_detail">
								<td>
									<input type="button" id="apply_1" onclick="time_in_func(1)" class="control_button" title="Click to apply time in." style="width:90px;" value="&#xf067;  Clock In" '.$disabled_1.'>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div style="width:8%; float:left;margin-left:100px; margin-bottom:30px;">
					<table class="vstaff_table" style="text-align: center;">
						<thead>
							<tr>
								<td class="header">Time Out</td>
							</tr>
						</thead>
						<tbody>
							<tr class="rowcolor row_detail">
								<td>'.$time_2.'</td>
							</tr>
							<tr class="rowcolor row_detail">
								<td>
									<input type="button" id="apply_2" onclick="time_in_func(2)" class="control_button" title="Click to apply time out." style="width:90px;" value="&#xf067;  Clock Out" '.$disabled_2.'>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</fieldset>
			<fieldset style="width: 378px; display:inline-block; margin-left:50px;">
			<legend style="font-size:1.5em;"><b>Second</b></legend>
				</br>
				<div style="width:8%; float:left;margin-left:75px; margin-bottom:30px;">
					<table class="vstaff_table" style="text-align: center;">
						<thead>
							<tr>
								<td class="header">Time In</td>
							</tr>
						</thead>
						<tbody>
							<tr class="rowcolor row_detail">
								<td>'.$time_3.'</td>
							</tr>
							<tr class="rowcolor row_detail">
								<td>
									<input type="button" id="apply_3" onclick="time_in_func(3)" class="control_button" title="Click to apply time in." style="width:90px;" value="&#xf067;  Clock In" '.$disabled_3.'>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div style="width:8%; float:left;margin-left:100px; margin-bottom:30px;">
					<table class="vstaff_table" style="text-align: center;">
						<thead>
							<tr>
								<td class="header">Time Out</td>
							</tr>
						</thead>
						<tbody>
							<tr class="rowcolor row_detail">
								<td>'.$time_4.'</td>
							</tr>
							<tr class="rowcolor row_detail">
								<td>
									<input type="button" id="apply_4" onclick="time_in_func(4)" class="control_button" title="Click to apply time out." style="width:90px;" value="&#xf067;  Clock Out" '.$disabled_4.'>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</fieldset>
			
			<fieldset style="width: 378px; display:inline-block; margin-left:50px;">
			<legend style="font-size:1.5em;"><b>Third</b></legend>
				</br>
			<div style="width:8%; float:left;margin-left:75px; margin-bottom:30px;">
				<table class="vstaff_table" style="text-align: center;">
					<thead>
						<tr>
							<td class="header">Time In</td>
						</tr>
					</thead>
					<tbody>
						<tr class="rowcolor row_detail">
							<td>'.$time_5.'</td>
						</tr>
						<tr class="rowcolor row_detail">
							<td>
								<input type="button" id="apply_5" onclick="time_in_func(5)" class="control_button" title="Click to apply time in." style="width:90px;" value="&#xf067;  Clock In" '.$disabled_5.'>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div style="width:8%; float:left;margin-left:100px; margin-bottom:30px;">
				<table class="vstaff_table" style="text-align: center;">
					<thead>
						<tr>
							<td class="header">Time Out</td>
						</tr>
					</thead>
					<tbody>
						<tr class="rowcolor row_detail">
							<td>'.$time_6.'</td>
						</tr>
						<tr class="rowcolor row_detail">
							<td>
								<input type="button" id="apply_6" onclick="time_in_func(6)" class="control_button" 	title="Click to apply time out." style="width:90px;" value="&#xf067;  Clock Out" '.$disabled_6.'>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</fieldset>
		</br>
		</br>
		</br>
		<input type="hidden" name="time_in_1" id="time_in_1" value="'.$time_1.'" />
		<input type="hidden" name="time_in_2" id="time_in_2" value="'.$time_2.'" />
		<input type="hidden" name="time_in_3" id="time_in_3" value="'.$time_3.'" />
		<input type="hidden" name="time_in_4" id="time_in_4" value="'.$time_4.'" />
		<input type="hidden" name="time_in_5" id="time_in_5" value="'.$time_5.'" />
		<input type="hidden" name="time_in_6" id="time_in_6" value="'.$time_6.'" />
	';
}
?>