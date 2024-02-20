<?php
include(__DIR__ . '/bootstrap/app.php');
include 'includes/validlogin.inc.php';
$db = new mysql();
date_default_timezone_set('Asia/Singapore');
$branch = ENV::COMPANY_BRANCH_CODE;

if ($_POST['task'] == 'time_in') {

	$date = date('Y-m-d');
	$is_yesterday = $_POST['is_yesterday'] ?? 0;
	if($is_yesterday){
		$date = date('Y-m-d',strtotime('-1 day'));
	}
	$insert_arr = [
		'emp_code' => $_SESSION['emp_code'],
		'emp_name' => $_SESSION['emp_name'],
		'date' => $date,
		'time' => date('Y-m-d H:i:s'),
		'branch' => $branch,
		'created_at' => date('Y-m-d H:i:s'),
		'action' => $_POST['id'],
	];
	$db->insert('vstaff_timesheet_integration',$insert_arr);
}

