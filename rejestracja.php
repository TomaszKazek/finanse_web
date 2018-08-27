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
	
	<script src='https://www.google.com/recaptcha/api.js'></script>	
</head>

<?php
	session_start();
	
	//if already loggen on go to bilans
	if(isset($_SESSION['logged'])&&($_SESSION['logged']==true))
	{
		header('Location:bilans.php');
		//skip following code
		exit();
	}
	
	//do if form was submitted
	if(isset($_POST['login']))
	{	
		//$ok stays true if all test passed
		$ok=true;
		
		$login=$_POST['login'];
		if((strlen($login)<3)||(strlen($login)>20))
		{
			$ok=false;
			$_SESSION['err_login']="Login musi się składać z od 3 do 20 znaków";
		}
		
		if(ctype_alnum($login)==false)
		{
			$ok=false;
			$_SESSION['err_login']="Login musi się składać wyłącznie z liter i/lub cyfr (bez polskich znaków)";
		}
		
		$email=$_POST['email'];
		//removes not allowed signs from mail entered
		$filter_email=filter_var($email,FILTER_SANITIZE_EMAIL);
		
		//fail if not allowed signs entered in mail
		if((filter_var($filter_email,FILTER_VALIDATE_EMAIL)==false)||($filter_email!=$email))
		{
			$ok=false;
			$_SESSION['err_email']="Adres email niepoprawny";
		}
		
		$password1=$_POST['password1'];
		$password2=$_POST['password2'];
		
		if ((strlen($password1)<3)||(strlen($password1)>40))
		{
			$ok=false;
			$_SESSION['err_password']="Hasło musi się składać z od 3 do 40 znaków";
		}
		
		if ($password1!=$password2)
		{
			$ok=false;
			$_SESSION['err_different']="Podano różne hasła";
		}
		
		$password=password_hash($password1,PASSWORD_DEFAULT);
		
		//captcha
		$secret_key="6LfPQ2wUAAAAALg_8MoKkkbsCT248JM7e9Li8OFX";
		
		$check=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
		
		$response=json_decode($check);
		
		if($response->success==false)
		{
			$ok=false;
			$_SESSION['err_captcha']="Potwiedź, że nie jesteś botem";
		}
		
		$_SESSION['keep_login']=$login;
		$_SESSION['keep_email']=$email;
		$_SESSION['keep_password1']=$password1;
		$_SESSION['keep_password2']=$password2;
		
		//bd credentials
		require_once"kontakt_z_baza.php";
		
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
				$result=$connection->query("SELECT user_id FROM users WHERE email='$email'");
				
				if(!$result) throw new Exception($connection->error);
				
				$mails=$result->num_rows;
				if($mails==1)
				{
					$ok=false;
					$_SESSION['err_email']="Podany email jest przypisany do już istniejącego konta";
				}
				
				$result=$connection->query("SELECT user_id FROM users WHERE login='$login'");
				
				if(!$result) throw new Exception($connection->error);
				
				$users=$result->num_rows;
				if($users==1)
				{
					$ok=false;
					$_SESSION['err_login']="Podany login jest już zajęty";
				}
				
				if($ok==true)
				{
					if($connection->query("INSERT INTO users VALUES (NULL,'$login','$email','$password')"))
					{
						header('Location: index.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				
				$connection->close();
			}
		}
		catch(Exception $error)
		{
			$_SESSION['err_login']="Błąd serwera";
		}
	}
?>

<body>
	
	<main>
		<form method="post">
		
			<?php
				if(isset($_SESSION['err_login']))
				{
					echo '<div class="warning">'.$_SESSION['err_login'].'</div>';
					//clear error after display
					unset($_SESSION['err_login']);
				}
			?>

			<input type="text" name="login" placeholder="login" value=
				"<?php
					if(isset($_SESSION['keep_login']))
					{
						echo $_SESSION['keep_login'];
						//clear previous value
						unset($_SESSION['keep_login']);
					}
				?>"
			onfocus="this.placeholder=''" onblur="this.placeholder='login'">
			
			<?php
				if(isset($_SESSION['err_email']))
				{
					echo '<div class="warning">'.$_SESSION['err_email'].'</div>';
					//clear error after display
					unset($_SESSION['err_email']);
				}
			?>
			
			<input type="email" name="email" placeholder="email" value=
				"<?php
					if(isset($_SESSION['keep_email']))
					{
						echo $_SESSION['keep_email'];
						//clear previous value
						unset($_SESSION['keep_email']);
					}
				?>"			
			onfocus="this.placeholder=''" onblur="this.placeholder='email'">
			
			<?php
				if(isset($_SESSION['err_password']))
				{
					echo '<div class="warning">'.$_SESSION['err_password'].'</div>';
					//clear error after display
					unset($_SESSION['err_password']);
				}
			?>
			
			<input type="password" name="password1" placeholder="hasło" value=
				"<?php
					if(isset($_SESSION['keep_password1']))
					{
						echo $_SESSION['keep_password1'];
						//clear previous value
						unset($_SESSION['keep_password1']);
					}
				?>"					
			onfocus="this.placeholder=''" onblur="this.placeholder='hasło'">
			
			<?php
				if(isset($_SESSION['err_different']))
				{
					echo '<div class="warning">'.$_SESSION['err_different'].'</div>';
					//clear error after display
					unset($_SESSION['err_different']);
				}
			?>
			
			<input type="password" name="password2" placeholder="potwierdź hasło" value=
				"<?php
					if(isset($_SESSION['keep_password2']))
					{
						echo $_SESSION['keep_password2'];
						//clear previous value
						unset($_SESSION['keep_password2']);
					}
				?>"	
			
			onfocus="this.placeholder=''" onblur="this.placeholder='potwierdź hasło'">			
			<?php
				if(isset($_SESSION['err_captcha']))
				{
					echo '<div class="warning">'.$_SESSION['err_captcha'].'</div>';
					//clear error after display
					unset($_SESSION['err_captcha']);
				}
			?>
			
			<div class="g-recaptcha" data-sitekey="6LfPQ2wUAAAAADKr-UZ3uWBL0dUwyW4DroLbLh-G"></div>
			
			<input type="submit" value="Zarejestruj">
		
		</form>
	</main>
	
</body>
</html>