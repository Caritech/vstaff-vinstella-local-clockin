<?php
$valid_time_now = time();
$link = 'index.php?details=Session Timeout';
if ($_SESSION['id'] == "") { 
    header('Location: '.$link);
}else if ($_SESSION['discard_after'] != '' && $valid_time_now > $_SESSION['discard_after']) { 
    header('Location: '.$link);
}else{
    $_SESSION['discard_after'] = $valid_time_now + ($_SESSION['session_timeout']*60);
}
?>