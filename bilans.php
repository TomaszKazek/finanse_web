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
	<!--<script src="jquery-3.3.1.min.js"></script>-->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	
	<script>
		
		$(document).ready(function(){
		var menuY = $('#menu').offset().top;
		
		var stickyMenu = function(){
		var ScrollY = $(window).scrollTop();
		
		if (ScrollY>menuY){
			$('#menu').addClass('sticky');
		} else {
			$('#menu').removeClass('sticky');
		}
		};
		
		stickyMenu();
		
		$(window).scroll(function(){
			stickyMenu();
		});
		});
		
	</script>
	
	<div class="container-fluid">
	<header class="row">
		<div class="col-sm-12">
			<h1>Finan<span class="dolar">$€</span> o<span class="dolar">$</span>obi<span class="dolar">$</span>t<span class="dolar">€</span></h1>
		</div>
	</header>
	<div class="row justify-content-center" id="menu">
		<div class="col-sm-6 col-md-3 col-lg-2">
			<div class="option">
				<div class="dropdown show">
					<button class="btn btn-secondary dropdown-toggle" href="bilans-wydatkow-i-przychodow-podsumowanie" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					 bilans
					</button>
					
					<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item" href="bilans-wydatkow-i-przychodow-podsumowanie">bilans miesiąca</a>
						<a class="dropdown-item" href="bilans-wydatkow-i-przychodow-podsumowanie">bilans wybranego okresu</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-3 col-lg-2">
			<a href="dodaj-nowy-wydatek-lub-przychod"><div class="option">dodaj wydatek</div></a>
		</div>
		<div class="col-sm-6 col-md-3 col-lg-2">
			<a href="dodaj-nowy-wydatek-lub-przychod"><div class="option">dodaj przychód</div></a>
		</div>
		<div class="col-sm-6 col-md-3 col-lg-2">
			<a href="wyloguj.php"><div class="option">wyloguj</div></a>
		</div>
	</div>
	
	<main class="row topBar">
		<div class="col-sm-6 col-lg-4 offset-lg-2">
			<h2>Wydatki</h2>
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Kategoria</th>
						<th scope="col">Wartość</th>
						<th scope="col">Waluta</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>wydatek1</td>
						<td>0,10</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>wydatek2</td>
						<td>10,99</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>wydatek3</td>
						<td>999999,99</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>wydatek4</td>
						<td>345,56</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>wydatek5</td>
						<td>32,67</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>wydatek6</td>
						<td>324,67</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>wydatek7</td>
						<td>732,47</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>wydatek8</td>
						<td>3243,50</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>wydatek9</td>
						<td>324,37</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>Razem</td>
						<td>dużo</td>
						<td>PLN</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-6 col-lg-4">
			<h2>Przychody</h2>
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Kategoria</th>
						<th scope="col">Wartość</th>
						<th scope="col">Waluta</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>przychód1</td>
						<td>0,01</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>przychód2</td>
						<td>0,15</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>przychód3</td>
						<td>1000,00</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>przychód4</td>
						<td>22,33</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>przychód5</td>
						<td>10,40</td>
						<td>PLN</td>
					</tr>
					<tr>
						<td>Razem</td>
						<td>mało</td>
						<td>PLN</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="justify-content-center col-sm-12">
			<h2>Bilans: zacznij oszczędzać</h2>
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