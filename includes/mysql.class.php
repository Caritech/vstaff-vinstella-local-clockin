<?php
session_start();
class mysql{
	function prompt($sMessage){
		echo $sMessage;
	}
	function query($query){
		$dbhost = 'localhost';
		$dbusername = 'root';
		$dbpassword = '';
		$dbname='vstaff';
		$con = mysqli_connect($dbhost, $dbusername, $dbpassword,$dbname);
		$query = mysqli_query($con,$query) or die(mysqli_error());
		return $query;
	}
	function close(){
		$dbhost = 'localhost';
		$dbusername = 'root';
		$dbpassword = '';
		$dbname='vstaff';
		$con = mysqli_connect($dbhost, $dbusername, $dbpassword,$dbname);
		mysqli_close($con);
	}
}
?>