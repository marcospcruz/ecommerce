<?php
session_start();
if(session_destroy()==true)
	echo 'Session clean';
else
	echo 'Session not clean';
?>
