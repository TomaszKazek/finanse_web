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
	
		<form action="zaloguj.php" method="post">
			
			<?php
				if(isset($_SESSION['error']))
				{
					echo $_SESSION['error'];
				}
			?>	

			<input type="text" name="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
			
			<input type="password" name="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'">
			
			<input type="submit" value="Zaloguj">
		
		</form>
	</main>
	
</body>
</html>