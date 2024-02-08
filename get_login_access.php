<?php 
include "includes/mysql.class.php";
$db = new mysql();
$sql_check = '
	SELECT emp_code, LOGIN_ID, NAME, PASSWORD
	FROM vstaff_emp_master
    WHERE 1
';
$result = $db->query($sql_check);
$num_row_local = $result->num_rows;
$url = 'https://vstaff.my/vstaff/gold/cpn/Vi36597863/get_login_access.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_POST, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS, 'task=get_login_access&cpn_code=Vi36597863&num_row_local='.$num_row_local);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$postResult = curl_exec($ch); 
$result = json_decode($postResult,true);
### compare the total numbers of data in local ###
//$curl_total_data = count($result);
//echo 'curl_total_data = '.$curl_total_data.'</br>';
//echo 'num_row_local = '.$num_row_local.'</br>';
//if($curl_total_data != $num_row_local){
	$no = 0;
	$sql_clear_local_db = '
		DELETE 
		FROM vstaff_emp_master 
		WHERE 1
	';
	$db->query($sql_clear_local_db);
	foreach($result as $u){
		$no++;
		echo $no;
		echo '. Name = '.$u['NAME'].'\r\n';
		echo 'EMP ID = '.$u['emp_code'].'\r\n';
		echo 'LOGIN ID = '.$u['LOGIN_ID'].'\r\n \r\n'; 
		
		$sql_insert = '
			INSERT INTO vstaff_emp_master (
				emp_code, 
				LOGIN_ID, 
				NAME, 
				PASSWORD
			) VALUES (
				"'.$u["emp_code"].'",
				"'.$u["LOGIN_ID"].'",
				"'.$u["NAME"].'",
				"'.$u["PASSWORD"].'"
			)
		';
		$db->query($sql_insert);
	}
//}
?>