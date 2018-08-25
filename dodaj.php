<?php
	session_start();
	
	if(!isset($_SESSION['logged']))
	{
		header('Location: logowanie.php');
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

			<input type="number" step="0.01" placeholder="0.00 PLN" onfocus="this.placeholder=''" onblur="this.placeholder='0.00 PLN'">
			
			<input type="text" placeholder="kategoria" onfocus="this.placeholder=''" onblur="this.placeholder='kategoria'">
			
			<input type="date" placeholder="data" onfocus="this.placeholder=''" onblur="this.placeholder='data'">
			
			<input type="submit" value="Dodaj">
		
		</form>
	</main>
	
</body>
</html>