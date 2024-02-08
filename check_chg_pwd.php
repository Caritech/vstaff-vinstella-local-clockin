<?php 
include "includes/mysql.class.php";
$db = new mysql();
$password_wrong_message = 'Wrong id or password or access denied, kindly contact HR department.';
if(trim($_POST['id']) != "" && trim($_POST['password']) != ""){
	$sql_login = "
		SELECT PASSWORD,NAME,emp_code
		FROM vstaff_emp_master
		WHERE 
		login_id = '".trim($_POST['id'])."'
	";
	$rs_login = $db->query($sql_login);
	list($PASSWORD,$NAME,$emp_code) = $rs_login->fetch_row();
	$salt = substr(trim($_POST['password']), 0, 2);
	$salt_password = crypt(trim($_POST['password']),$salt);
	$emp_pwd_verify = password_verify(trim($_POST['password']),$PASSWORD);
	$emp_salt_verify = "";
	if($salt_password == $PASSWORD){
	  $emp_salt_verify = '1';
	}
	if($emp_pwd_verify == '1' || $emp_salt_verify == '1'){
		$_SESSION['id'] = trim($_POST['id']);
		$_SESSION['emp_name'] = $NAME;
		$_SESSION['emp_code'] = $emp_code;
		$_SESSION["session_timeout"] = '60';
		$_SESSION['discard_after'] = time() + ($_SESSION['session_timeout']);
		header("Location: main.php");
	}else{
		header("Location: index.php?details=".$password_wrong_message);
	}  
	curl_close($ch);
}else{
    header("Location: index.php?details=".$password_wrong_message);
}
?>