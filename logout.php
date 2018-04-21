<?php
	session_start();
	//unset($_SESSION['count']);
	//unset($_SESSION['logado']);
	//unset($_SESSION['usuario']);
	session_unset();
	header('Location: index.php');
?>