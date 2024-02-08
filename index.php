<?php
session_start();
session_destroy();
session_unset();
error_reporting(E_ALL ^ E_NOTICE);
?>
<title>vstaff login</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link type="image/x-icon" href="images/waffles_favicon.ico" rel="shortcut icon" />
<link type="text/css" href="includes/jquery-ui-1.11.4/jquery-ui-1.11.4/jquery-ui.css" rel="Stylesheet" />
<script type="text/javascript" src="includes/jquery-ui-1.11.4/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" src="includes/jquery-ui-1.11.4/jquery-ui-1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="includes/font-awesome/css/font-awesome.min.css">
<style>
    .noselect,
    #radio,
    #cat_rad,
    .radio {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
    }

    .login_page_row1 {
        text-align: center;
        padding-top: 20px;
        padding-bottom: 30px;
    }

    .m_c {
        background: #272727;
        background: -webkit-linear-gradient(#4d4d4d, #272727, #272727, #4d4d4d);
        background: -o-linear-gradient(#4d4d4d, #272727, #272727, #4d4d4d);
        background: -moz-linear-gradient(#4d4d4d, #272727, #272727, #4d4d4d);
        background: linear-gradient(#4d4d4d, #272727, #272727, #4d4d4d);
    }
    }

    .sign_in {
        margin-top: 29px;
    }

    .box_header {
        margin: auto;
        width: 561px;
        padding: 10px;
        border-radius: 3px;
        text-align: left;
        color: white;
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
        font-weight: bold;
        font-size: 22px;
        height: 26px;
    }

    .sign_in_title {
        white-space: nowrap;
        float: left;
        padding: 2px 12px;
    }

    .center-div {
        margin: auto;
        width: 519px;
        padding: 30px;
        border-radius: 3px;
        /*background: #f1f1f1;*/
        border: 1px solid #ccc;
        text-align: center;
        border-top-right-radius: 0px;
        border-top-left-radius: 0px;
    }

    .login_icon {
        padding: 10px;
        margin-bottom: 12px;
        width: 81px;
        display: inline-block;
        border-radius: 100%;
        width: 70px;
        height: 70px;
    }

    input[type="text"],
    input[type="password"] {
        padding: 10px;
        font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
        font-size: 14px;
        color: #464a4e;
        background: #FFFFFF;
        border: 1px solid #c7cacd;
        margin: 5px 0px;
        width: 337px;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: black;
        outline: none;
        box-shadow: 2px 2px 5px #888888;
    }

    a {
        color: #337ab7;
        text-decoration: none;
    }

    .a:hover {
        text-decoration: underline;
    }

    .login_btn {
        width: 337px;
        margin-top: 5px;
    }

    .c_btn:active {
        text-shadow: 0 -1px 0 #444, 0 0 5px #ffd, 0 0 8px #fff;
        -webkit-transform: translateY(3px);
        transform: translateY(3px);
        -webkit-animation: none;
        animation: none;
    }

    .btn {
        color: white;
        /* border-radius: 3px; */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        font-size: 14px;
        cursor: pointer;
        height: 40px;
        border: 0px solid black;
        font-family: Arial, sans-serif, FontAwesome;
        */
    }

    .btn:hover {
        background: #2381AE;
        /* For browsers that do not support gradients */
        background: -webkit-linear-gradient(#2682AF, #197BAB, #0972A5, #0972A5);
        /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(#2682AF, #197BAB, #0972A5, #0972A5);
        /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(#2682AF, #197BAB, #0972A5, #0972A5);
        /* For Firefox 3.6 to 15 */
        background: linear-gradient(#2682AF, #197BAB, #0972A5, #0972A5);
        /* Standard syntax */
        border: 1px solid #3b5998;
        outline: none;
    }

    .b {
        font-weight: bold;
    }

    .red {
        color: red;
    }

    .red_b {
        border: 1px solid red !important;
    }

    body {
        display: none;
    }
</style>
<script>
    $(document).ready(function() {
        $("body").css("display", "none");
        $("body").fadeIn(600);
        $('body').on('click', '#click_remember_me', function() {
            if ($('#chk_remember').prop('checked')) {
                $('#chk_remember').prop('checked', false);
            } else {
                $('#chk_remember').prop('checked', true);
            }
        });
    });
</script>
<div class="login_page_row1">
    <div>
        <img src="images/vstaff_logo_fit_header.jpg" width="170px;">
    </div>
</div>
<form name="login" method="post" action="check_chg_pwd.php">

    <div class="sign_in">
        <div class="box_header m_c">
            <div class="sign_in_title">
                <i class="fa fa-lock"></i>
            </div>
        </div>
        <div class="center-div">
            <div class="login_icon m_c" style="padding-bottom:2px;">
                <i class="fa fa-user fa-4x" style="color:white;"></i>
            </div>
            <br>
            <span class="b red"><?= $_GET['details'] ?? ''; ?></span>
            <br>
            <input type="text" value="<?=trim($_GET['uid']??'')?>" name="id" placeholder="Enter your username" autofocus>
            <br>
            <input type="password" value="<?= trim($_GET['pwd']??'')?>" name="password" placeholder="Enter your password">
            <br>
            <div style="padding-bottom:20px;"></div>
            <input type="submit" value="&#xf090  Login" name="btnLogin" class="login_btn m_c noselect c_btn btn">

            <br><br>
            <!--<div style="float:right;padding-right:90px;">
			<a href="fpwd_vstaff2.php" class="a">Forgot Password</a>
		</div>-->
        </div>
    </div>
    <br>
</form>