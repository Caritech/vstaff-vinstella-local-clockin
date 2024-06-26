<?php
include(__DIR__ . '/bootstrap/app.php');
$CPN_CODE = ENV::COMPANY_CODE;

$db = new mysql();
$today_date = date('Y-m-d');
$last_week_date = date('Y-m-d',strtotime('-14 days',strtotime($today_date)));

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
            action = '".$row['action']."'\r\n<br>
        ";

        $data = '&emp_code='.$row['emp_code'].'&emp_name='.$row['emp_name'].'&date='.$row['date'].'&time='.$row['time'].'&branch='.$row['branch'].'&action='.$row['action'];
        $url = ENV::API_URL.'/get_timesheet_integration_weishen.php';

        $ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, 'task=get_all_clocking_details&cpn_code='.$CPN_CODE.$data);
        $server_output = curl_exec($ch);
        print_r($server_output);
        curl_close($ch);
    }
	$last_week_date = date ("Y-m-d", strtotime("+1 day", strtotime($last_week_date)));
}
?> 
