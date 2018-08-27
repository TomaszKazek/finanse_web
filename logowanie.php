<?php
	session_start();
	
	//if user is logged in go to bilans.php
	if(isset($_SESSION['logged'])&&($_SESSION['logged']==true))
	{
		header('Location:bilans.php');
		exit();
	}
	
	//do only if form was already submitted ($_POST set)
	if(isset($_POST['login']))
	{	
		//bd credentials
		require_once "kontakt_z_baza.php";
		
		//mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			//variables defined in kontakt_baza.php
			//@ to not show worning when host not found
			$connection = @new mysqli($host,$db_user,$db_password,$db_name);
			
			//if connection set up successfully ->else if not throw exception
			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//get variables from form
				$login = $_POST['login'];
				$password = $_POST['password'];
				
				//convert signs allowing sql injection
				$login=htmlentities($login,ENT_QUOTES,"UTF-8");
				
				//do if connection works (failed connection give 0)
				if($result = $connection->query(
				//%s will be replaced by mysqli_real_escape_strings
				sprintf("SELECT * FROM users WHERE login='%s'",
				//prevents query errors (e.g. removes ' )
				mysqli_real_escape_string($connection,$login))))
				{
					$users=$result->num_rows;
					if($users==1)
					{
							//create tab with index from tab from database
							$row = $result->fetch_assoc();
							//compares hashed passwords
							if(password_verify($password,$row['password']))
							{
							$_SESSION['logged']=true;
							$_SESSION['$user']=$row['login'];
							
							$connection->close();
							unset($_SESSION['error']);
							unset($_SESSION['err_pass']);
							header('Location: bilans.php');
							}
						else
						{
						$_SESSION['err_pass']='<span class="warning">Nieprawidłowe hasło!</span>';
						}
					}
					else
					{
						$_SESSION['error']='<span class="warning">Niepoprawny login!</span>';
					}
				}
				else
				{
						throw new Exception($connection->error);
				}
				
				$connection->close();
			}
		}
		catch(Exception $error)
		{
			$_SESSION['error']='<span class="warning">Błąd serwera!</span>';
		}
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>finanse</title>
	<meta name="description" content="strona służąca porządkowaniu finansów osobistych" />
	<meta name="keywords" content="bilans, finanse, wydatki" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="author" content="Tomasz Kazek" />
	
	<link rel="stylesheet" href="style.css" type="text/css"/>
	
</head>
<body>
	<main>
	
		<form method="post">
			
			<?php			
				if(isset($_SESSION['error']))
				{
					echo $_SESSION['error'];
				}
			?>	

			<input type="text" name="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
			
			<?php			
				if(isset($_SESSION['err_pass']))
				{
					echo $_SESSION['err_pass'];
				}
			?>	
			
			<input type="password" name="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'">
			
			<input type="submit" value="Zaloguj">
		
		</form>
	</main>
	
</body>
</html>