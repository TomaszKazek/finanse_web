<?php
	session_start();
	
	//redirect to logging if not logged
	if(!isset($_SESSION['logged']))
	{
		header('Location: logowanie.php');
		exit();
	}
	
	//bd credentials
	require_once"kontakt_z_baza.php";
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
	
	<!--bootstrap-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
	<!--css-->
	<link rel="stylesheet" href="style.css" type="text/css"/>
	
</head>
<body>
	<!--jquery-->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	
	<script>
		
		//keep menu visible even if scrolled down
		$(document).ready(function()
		{
			var menuY = $('#menu').offset().top;
			
			var stickyMenu = function()
			{
				var ScrollY = $(window).scrollTop();
				
				if (ScrollY>menuY)
				{
					$('#menu').addClass('sticky');
				}
				else
				{
					$('#menu').removeClass('sticky');
				}
			};
			
			stickyMenu();
			
			$(window).scroll(function()
			{
				stickyMenu();
			});
		});
		
	</script>
	
	<div class="container-fluid">
	<header class="row justify-content-center">
		<div class="col-sm-4 col-md-3 col-lg-2">
			<h1>Finan<span class="dolar">$€</span> </h1>
		</div>
		<div class="col-sm-4 col-md-3 col-lg-2">
			<h1> o<span class="dolar">$</span>obi<span class="dolar">$</span>t<span class="dolar">€</span></h1>
		</div>
	</header>
	<div class="row justify-content-center" id="menu">
		<div class="col-sm-6 col-md-3 col-lg-2">
			<div class="option">
				<div class="dropdown show">
					<button class="btn btn-secondary dropdown-toggle" href="bilans-wydatkow-i-przychodow-podsumowanie" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					 filtruj
					</button>
					
					<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item" href="ostatni miesiac.php">ostatni miesiąc</a>
						<a class="dropdown-item" href="wybierz-okres">wybrany okres</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-6 col-md-3 col-lg-2">
			<div class="option">
				<div class="dropdown show">
					<button class="btn btn-secondary dropdown-toggle" href="bilans-wydatkow-i-przychodow-podsumowanie" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					 dodaj kategorię
					</button>
					
					<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item" href="dodaj-kategorie-wydatku">wydatku</a>
						<a class="dropdown-item" href="dodaj-kategorie-przychodu">przychodu</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-6 col-md-3 col-lg-2">
			<a href="dodaj-nowy-wydatek"><div class="option">dodaj wydatek</div></a>
		</div>
		<div class="col-sm-6 col-md-3 col-lg-2">
			<a href="dodaj-nowy-przychod"><div class="option">dodaj przychód</div></a>
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
						<th scope="col">Data</th>
						<th scope="col">Komentarz</th>
					</tr>
				</thead>
				<tbody>
					<?PHP
						try
						{
							//variables defined in kontakt_baza.php
							//@ to not show worning when host not found
							$connection = @new mysqli($host,$db_user,$db_password,$db_name);
							//polish signs
							$connection -> query ('SET NAMES utf8');
							//if connection set up successfully ->else if not throw exception
							if($connection->connect_errno!=0)
							{
								throw new Exception(mysqli_connect_errno());
							}
							else
							{
								$result = $connection->query("SELECT * FROM expenses_categories");
								$names=$result->fetch_all();
								
								//if dates were chosen get expenses from period
								if(isset($_POST['begDate']))
								{
									$result = $connection->query("SELECT * FROM expenses WHERE user_id={$_SESSION['user']} AND date BETWEEN '{$_POST['begDate']}' AND '{$_POST['endDate']}' ");
								}
								//if last month were chosen get expenses from last month
								elseif(isset($_SESSION['lastMonth']))
								{
									$result = $connection->query("SELECT * FROM expenses WHERE user_id={$_SESSION['user']} AND date BETWEEN '{$_SESSION['lastMonth']}' AND '{$_SESSION['today']}' ");
								}
								//take everything by default
								else
								{
									$result = $connection->query("SELECT * FROM expenses WHERE user_id={$_SESSION['user']}");
								}
								$expenses = $result->fetch_all();
								//change category number from expenses tab to name from expenses_categories
								foreach($expenses as $expense)
								{
									$i=0;
									while(1)
									{
										if($names[$i][0]==$expense[2])
										{
											$category=$names[$i][1];
											break;
										}
										else
										{
											$i++;
										}
									}
									//print expense to tab
									echo'<tr>';
										echo '<td>'.$category.'</td>';
										//echo '<td>'.$today.'</td>';
										echo '<td>'.$expense[4].'</td>';
										echo '<td>'.$expense[3].'</td>';
										echo '<td>'.$expense[5].'</td>';
									echo'</tr>';
								}
							}
						}
					
						catch(Exception $error)
						{
							$_SESSION['err']="Błąd serwera";
						}
					?>
					<tr>
						<td>Razem</td>
						<td>
						<?PHP
							//other sum for each case (compare above)
							if(isset($_POST['begDate']))
								{
									$result = $connection->query("SELECT SUM(value) FROM expenses WHERE user_id={$_SESSION['user']} AND date BETWEEN '{$_POST['begDate']}' AND '{$_POST['endDate']}' ");
								}
								elseif(isset($_SESSION['lastMonth']))
								{
									$result = $connection->query("SELECT SUM(value) FROM expenses WHERE user_id={$_SESSION['user']} AND date BETWEEN '{$_SESSION['lastMonth']}' AND '{$_SESSION['today']}' ");
								}
								else
								{
									$result = $connection->query("SELECT SUM(value) FROM expenses WHERE user_id={$_SESSION['user']}");
								}
							$sumE=$result->fetch_all();
							echo $sumE[0][0];
						?>
						</td>
						<td></td>
						<td>to za dużo</td>
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
						<th scope="col">Data</th>
						<th scope="col">Komentarz</th>
					</tr>
				</thead>
				<tbody>
					<?PHP
						try
						{
							//variables defined in kontakt_baza.php
							//@ to not show worning when host not found
							$connection = new mysqli($host,$db_user,$db_password,$db_name);
							$connection -> query ('SET NAMES utf8');
							//if connection set up successfully ->else if not throw exception
							if($connection->connect_errno!=0)
							{
								throw new Exception(mysqli_connect_errno());
							}
							else
							{
								//the same as for expenses
								$result = $connection->query("SELECT * FROM incomes_categories");
								$names=$result->fetch_all();
								
								if(isset($_POST['begDate']))
								{
									$result = $connection->query("SELECT * FROM incomes WHERE user_id={$_SESSION['user']} AND date BETWEEN '{$_POST['begDate']}' AND '{$_POST['endDate']}' ");
								}
								elseif(isset($_SESSION['lastMonth']))
								{
									$result = $connection->query("SELECT * FROM incomes WHERE user_id={$_SESSION['user']} AND date BETWEEN '{$_SESSION['lastMonth']}' AND '{$_SESSION['today']}' ");
								}
								else
								{
									$result = $connection->query("SELECT * FROM incomes WHERE user_id={$_SESSION['user']}");
								}
								$incomes = $result->fetch_all();
								foreach($incomes as $income)
								{
									$i=0;
									while(1)
									{
										if($names[$i][0]==$income[2])
										{
											$category=$names[$i][1];
											break;
										}
										else
										{
											$i++;
										}
									}
									echo'<tr>';
										echo '<td>'.$category.'</td>';
										echo '<td>'.$income[4].'</td>';
										echo '<td>'.$income[3].'</td>';
										echo '<td>'.$income[5].'</td>';
									echo'</tr>';
								}
							}
						}
					
						catch(Exception $error)
						{
							$_SESSION['err']="Błąd serwera";
						}
					?>
					<tr>
						<td>Razem</td>
						<td>
						<?PHP
							if(isset($_POST['begDate']))
								{
									$result = $connection->query("SELECT SUM(value) FROM incomes WHERE user_id={$_SESSION['user']} AND date BETWEEN '{$_POST['begDate']}' AND '{$_POST['endDate']}' ");
									unset ($_POST['begDate']);
									unset ($_POST['endDate']);
								}
								elseif(isset($_SESSION['lastMonth']))
								{
									$result = $connection->query("SELECT SUM(value) FROM incomes WHERE user_id={$_SESSION['user']} AND date BETWEEN '{$_SESSION['lastMonth']}' AND '{$_SESSION['today']}' ");
									unset ($_SESSION['lastMonth']);
									unset ($_SESSION['today']);
								}
								else
								{
									$result = $connection->query("SELECT SUM(value) FROM incomes WHERE user_id={$_SESSION['user']}");
								}
							$sumI=$result->fetch_all();
							echo $sumI[0][0];
						?>
						</td>
						<td></td>
						<td>to za mało</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="justify-content-center col-sm-12">
			<h2>Bilans: 
				<?PHP
					echo $sumI[0][0]-$sumE[0][0];
				?>
			</h2>
		</div>
	</main>
	</div>
	
	<footer>
			Autor: Tomasz Kazek | strona wykonana na potrzeby projektu <a href="http://www.przyszlyprogramista.pl" target="_blank">przyszłyprogramista.pl</a> | kontakt: tomasz.kazek.89@gmail.com
	</footer>
	
	<!--bootstrap-->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
</body>
</html>