<?php
include "includes/mysql.class.php";
$db = new mysql();
$tt = 'Timesheet';
include 'includes/vstaffmeta.inc_latest.php';
include 'includes/validlogin.inc.php';
?>
<link type="image/x-icon" href="images/waffles_favicon.ico" rel="shortcut icon"/>
<link type="text/css" href="includes/jquery-ui-1.11.4/jquery-ui-1.11.4/jquery-ui.css" rel="Stylesheet"/>
<script type="text/javascript" src="includes/jquery-ui-1.11.4/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" src="includes/jquery-ui-1.11.4/jquery-ui-1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="includes/font-awesome/css/font-awesome.min.css">
<script>
$(document).ready(function(){
	display();
});
function clock(){
	//Save the times in variables
	var today = new Date();
	var hours = today.getHours();
	var minutes = today.getMinutes();
	var seconds = today.getSeconds();
	//Set the AM or PM time
	if(hours >= 12){
	  meridiem = " PM";
	}else{
	  meridiem = " AM";
	}

	//convert hours to 12 hour format and put 0 in front
	if(hours>12){
		hours = hours - 12;
	}else if (hours===0){
		hours = 12;	
	}
	//Put 0 in front of single digit minutes and seconds
	if(minutes<10){
		minutes = "0" + minutes;
	}else{
		minutes = minutes;
	}
	if(seconds<10){
		seconds = "0" + seconds;
	}else{
		seconds = seconds;
	}
	document.getElementById("clock").innerHTML = (hours + ":" + minutes + ":" + seconds + meridiem);
}
setInterval('clock()', 100);
function time_in_func(id){
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
	if(id == '6' && time_in_5 == "N/A"){
		validate = '1';
	}
	if(id == '5' && time_in_4 == "N/A"){
		validate = '1';
	}
	if(id == '4' && time_in_3 == "N/A"){
		validate = '1';
	}
	if(id == '3' && time_in_2 == "N/A"){
		validate = '1';
	}
	if(id == '2' && time_in_1 == "N/A"){
		validate = '1';
	}
	
	if(validate == '1'){
        swal({
         title:"Please fill up the required field(s)",
         type:"warning",
        },function(){
                
        });
    }else{
		$.ajax({
		  type: "POST",
		  url: 'main_ajax.php',
		  data:{
			"task":"time_in",
			"id":id,
			"today":today,
			"time":time,
		  },
		  success: function(data){
			swal({
			  title: "Time in successfully",
			  text: "",
			  type: "success",
			  showCancelButton: false,   
			  confirmButtonColor: "#8cd4f5",  
			  confirmButtonText: "OK", 
			  showLoaderOnConfirm: true,
			  closeOnConfirm: true
			}, function(){
				location.reload();
			});
		  }
		});    
	}
}
function display(){
	$.ajax({
		type:"POST",
		url: "main_ajax.php",
		data:{
			"task":"display",
		},
		success:function(data){
			$('#display').html(data);
		},
	});
}
function close_dl_func(){
	$('#dl').dialog('close');
	$('#dl_rs').html('');
}
</script>
<!--strftime("%I:%M%p",strtotime($row["time_in"])-->
<?php
 echo '
	<div id="dl"><div id="dl_rs"></div></div>
		<div style="margin-left:28px; margin-right:28px;margin-top:20px;">
			<div>
				<div style="display:inline-block;">
					<h1>My Attendance</h1>
				</div>
				<div style="display:inline-block;float:right;" class="noselect">
					<a class="vs_Ha vs_3e vs_af vs_yb signout_btn c_btn" href="http://localhost/vinstella/logout.php">
					<i class="fa fa-sign-out fa-lg"></i>  Sign Out
					</a>
				</div>
			</div>
			</br>
			</br>
			<div id = "display"></div>
		</div>
	</div>
 ';
?>