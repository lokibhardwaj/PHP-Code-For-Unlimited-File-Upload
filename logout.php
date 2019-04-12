<?php
session_start();
session_destroy(); 
session_unset();

$past = time() - 100;
setcookie('remember_me', " ", $past);
setcookie('remember_me_pwd', " ", $past);

ob_start();
header("Location: index.php");
ob_end_flush(); 
?>