<?php
include "includes/mysql.class.php";
$db = new mysql();
date_default_timezone_set('Asia/Singapore');
$tt = 'Timesheet';
$branch = '';

if ($_POST['task'] == 'time_in') {
	$sql = '
		INSERT INTO vstaff_timesheet_integration(	
			emp_code,emp_name,date,time,branch,created_at,action
		)VALUES (
			"' . $_SESSION['emp_code'] . '","' . $_SESSION['emp_name'] . '",now(),CURRENT_TIMESTAMP,"' . $branch . '",CURRENT_TIMESTAMP,' . $_POST['id'] . '
		)
	';
	$db->query($sql);
}

