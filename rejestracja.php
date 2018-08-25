<?php
	session_start();
	
	if(isset($_SESSION['logged'])&&($_SESSION['logged']==true))
	{
		header('Location:bilans.php');
		exit();
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
		<form>

			<input type="text" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
			
			<input type="email" placeholder="email" onfocus="this.placeholder=''" onblur="this.placeholder='email'">
			
			<input type="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'">
			
			<input type="password" placeholder="potwierdź hasło" onfocus="this.placeholder=''" onblur="this.placeholder='potwierdź hasło'">
			
			<input type="submit" value="Zarejestruj">
		
		</form>
	</main>
	
</body>
</html>