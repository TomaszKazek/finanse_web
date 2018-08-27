<?php
	session_start();
	
	if(isset($_SESSION['keep_login'])) unset($_SESSION['keep_login']);
	if(isset($_SESSION['keep_email'])) unset($_SESSION['keep_email']);
	if(isset($_SESSION['keep_password1'])) unset($_SESSION['keep_password1']);
	if(isset($_SESSION['keep_password2'])) unset($_SESSION['keep_password2']);
	
	if(isset($_SESSION['err_login'])) unset($_SESSION['err_login']);
	if(isset($_SESSION['err_email'])) unset($_SESSION['err_email']);
	if(isset($_SESSION['err_password'])) unset($_SESSION['err_password']);
	if(isset($_SESSION['err_different'])) unset($_SESSION['err_different']);
	if(isset($_SESSION['err_captcha'])) unset($_SESSION['err_captcha']);
	
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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>finanse</title>
	<meta name="description" content="strona służąca porządkowaniu finansów osobistych" />
	<meta name="keywords" content="bilans, finanse, wydatki" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="author" content="Tomasz Kazek" />
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css" type="text/css"/>
	
</head>
<body>
	<div class="container-fluid">
	<header class="row">
		<div class="col-sm-12">
			<h1>Finan<span class="dolar">$€</span> o<span class="dolar">$</span>obi<span class="dolar">$</span>t<span class="dolar">€</span></h1>
		</div>
	</header>
	<div class="row justify-content-end" id="menu">
		<div class="col-sm-2 col-lg-1">
			<a href="zarejestruj-sie-i-zapanuj-nad-portfelem"><div class="option">rejestracja</div></a>
		</div>
		<div class="col-sm-2 col-lg-1">
			<a href="logowanie"><div class="option">logowanie</div></a>
		</div>
	</div>
	<main class="row col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 justify-content-center">
		<div>
		Czy wiesz ile ekspresów do kawy mógłbyś kupić gdybyś nosił kawę w kubku termicznym zamiast korzystać z automatów?<br/>
		Czy wiesz na ile wycieczek więcej mógłbyś pojechać nie wydając pieniędzy w pułapkach na turystów?<br/>
		Jak często wypłata kończy się tydzień przed następną?<br/>
		Zapisując swoje wydatki (i przychody) znacznie łatwiej kontrolować swoje finanse i wygenerować oszczędności zamiast się zadłużac.<br/>
		Korzystając z tej strony będziesz mógł/mogła robić to z każdego miejsca o dowolnej porze.<br/>
		Aby zacząć panować nad swoim portfelem zarejestruj się lub zaloguj jeśli masz już konto.
		</div>
	</main>
	</div>
	<footer>
			<!--stopka-->
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
</body>
</html>