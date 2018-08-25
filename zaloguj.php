<?php

	session_start();

	if((!isset($_POST['login']))||(!isset($_POST['password'])))
	{
		header('Location:index.php');
		exit();
	}
	
	require_once "kontakt_z_baza.php";
	
	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login=htmlentities($login,ENT_QUOTES,"UTF-8");
		$password=htmlentities($password,ENT_QUOTES,"UTF-8");
	
		if($result = @$connection->query(
		sprintf("SELECT * FROM users WHERE login='%s' AND password='%s'",
		mysqli_real_escape_string($connection,$login),
		mysqli_real_escape_string($connection,$password))))
		{
			$users=$result->num_rows;
			if($users==1)
			{
				$_SESSION['logged']=true;
				
				$row = $result->fetch_assoc();
				$_SESSION['$user']=$row['login'];
				
				$result->close();
				unset($_SESSION['error']);
				header('Location: bilans.php');
			}
			else
			{
				$_SESSION['error']='<span class="warning">Nieprawidłowy login lub hasło!</span>';
				header('Location: logowanie.php');
			}
		}
		else
		{
			
		}
		
		$connection->close();
	}
?>