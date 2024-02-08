<?php
include "includes/mysql.class.php";
$db = new mysql();
$today_date = date('Y-m-d');
$last_week_date = date('Y-m-d',strtotime('-40 days',strtotime($today_date)));
$today_year = date('Y'); 
$today_month = date('m');

//LOOP 14 DAYS BEFORE TODAYS
while (strtotime($last_week_date) <= strtotime($today_date)){
    $this_date_of_yearmonth = date('Ym',strtotime($last_week_date));
    $date = date('Y-m-d',strtotime($last_week_date));
   
    //LOOP ALL EMPLOYEE FOR THIS DATE
    $sql = "
		SELECT emp_code,emp_name,date,time,branch,action
		FROM vstaff_timesheet_integration
		WHERE date = '".$date."'
    ";
    $result = $db->query($sql);
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        echo "
		emp_code = '".$row['emp_code']."'
		emp_name = '".$row['emp_name']."'
		date = '".$row['date']."'
		time = '".$row['time']."'
		branch = '".$row['branch']."'
		action = '".$row['action']."'\r\n
        ";
        //PASS ALL DATA
        $data = '&emp_code='.$row['emp_code'].'&emp_name='.$row['emp_name'].'&date='.$row['date'].'&time='.$row['time'].'&branch='.$row['branch'].'&action='.$row['action'];
        $ch = curl_init();
        //PASS ALL DATA TO THIS LINK
        //$url = 'https://dev.vstaff.my/vstaff/gold/cpn/ef74856713/get_timesheet_integration_weishen.php';

		$url = 'https://vstaff.my/vstaff/gold/cpn/Vi36597863/get_timesheet_integration_weishen.php';
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        //PASS DATABASE NAME
        //curl_setopt($ch,CURLOPT_POSTFIELDS, 'task=get_all_clocking_details&cpn_code=ef74856713'.$data);
        curl_setopt($ch,CURLOPT_POSTFIELDS, 'task=get_all_clocking_details&cpn_code=Vi36597863'.$data);
        $server_output = curl_exec($ch);
        print_r($server_output);
        curl_close($ch);
    }
	$last_week_date = date ("Y-m-d", strtotime("+1 day", strtotime($last_week_date)));
}
?> 
