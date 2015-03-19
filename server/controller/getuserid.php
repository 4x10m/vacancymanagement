<?php
	session_start();

	if(isset($_SESSION['userid']) and !empty($_SESSION['userid'] and $_SESSION['userid'] > 0)) {
		echo json_encode(array('id'=>$_SESSION['userid']));
	}
	else {
		echo 'ok1';
	}
?>