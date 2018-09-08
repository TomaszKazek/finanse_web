<?PHP
	session_start();
	
	if(!isset($_SESSION['logged']))
	{
		header('Location: logowanie.php');
		exit();
	}
	
	$_SESSION['lastMonth']=date('Y-m-d', strtotime('last month'));
	$_SESSION['today']=date('Y-m-d');
	
	header('Location: bilans.php');