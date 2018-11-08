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
					$('#menu').addClass('fixed-top');
					$("body").css("padding-top","70px");
				}
				else
				{
					$('#menu').removeClass('fixed-top');
					$("body").css("padding-top","0");
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
	</div>
	
	<nav class="navbar navbar-expand-md" id="menu">
		<div class="container">
			<span class="gold">Finanse osobiste</span>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuBar" aria-controls="menu" aria-expanded="false" aria-label="włącznik nawigacji">menu</button>
		
		<div class="collapse navbar-collapse" id="menuBar">
			<ul class="navbar-nav">
				<?php if(!$portal->getUser()):?>
					<li class="nav-item">
						<a class="nav-link" href="finanse-osobiste?action=showRegistrationForm">rejestracja</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="finanse-osobiste?action=showLoginForm">logowanie</a>
					</li>
				<?php elseif($portal->getUser()):?>
					<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true">filtruj</a>
						<div class="dropdown-menu" labelledby="submenu">
							<a class="dropdown-item" href="finanse-osobiste">pokaż wszystko</a>
							<a class="dropdown-item" href="finanse-osobiste?action=lastMonth">ostatni miesiąc</a>
							<a class="dropdown-item" href="finanse-osobiste?action=chooseDates">wybrany okres</a>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true">dodaj kategorię</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="finanse-osobiste?action=showAddExpenseCategoryForm">wydatku</a>
								<a class="dropdown-item" href="finanse-osobiste?action=showAddIncomeCategoryForm">przychodu</a>
							</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true">usuń kategorię</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="finanse-osobiste?action=showDeleteExpenseCategoryForm">wydatku</a>
								<a class="dropdown-item" href="finanse-osobiste?action=showDeleteIncomeCategoryForm">przychodu</a>
							</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="finanse-osobiste?action=showAddExpenseForm">dodaj wydatek</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="finanse-osobiste?action=showAddIncomeForm">dodaj przychód</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true">ustawienia</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="finanse-osobiste?action=showChangePasswordForm">zmiana hasła</a>
							</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="finanse-osobiste?action=logout">wyloguj</a>
					</li>
				<?php endif ?>
			</ul>
		</div>
		</div>
	</nav>
	
	<div class="container-fluid">
	<?php if(!$portal->getUser()):?>
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
	<?php elseif($portal->getUser()):?>
		<main class="row topBar">
			<div class="col-md-6 col-lg-5 offset-lg-1">
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
						
							//bd credentials
							require_once "kontakt_z_baza.php";
							$_SESSION['server_error']=false;
							
							try
							{
								//variables defined in kontakt_baza.php
								//@ to not show worning when host not found
								$connection = @new mysqli($host,$db_user,$db_password,$db_name);
								//polish signs
								@$connection -> query ('SET NAMES utf8');
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
									if(isset($_POST['begDate'])&&isset($_POST['endDate']))
									{
										$result = $portal->getChosenExpenses($connection,$_POST['begDate'],$_POST['endDate']);
									}
									//if last month were chosen get expenses from last month
									elseif(isset($_SESSION['lastMonth'])&&$_SESSION['lastMonth']==true)
									{
										$result = $portal->getChosenExpenses($connection,date('Y-m-d', strtotime('last month')),date('Y-m-d'));
									}
									//take everything by default
									else
									{
										$result = $portal->getAllExpenses($connection);
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
											echo '<td><form class="delete" action="index.php?action=delete_expense" method="post"><input type="hidden" name="expense_id" value="'.$expense[0].'"><input class="delete-button delete" type="submit" name="delete" value="X"></form></td>';
										echo'</tr>';
									}
								}
							}
						
							catch(Exception $error)
							{
								echo "Błąd serwera!";
								$_SESSION['server_error']=true;
							}
						?>
						<tr>
							<td>Razem</td>
							<td>
							<?PHP
								//other sum for each case (compare above)
								if(isset($_POST['begDate'])&&isset($_POST['endDate'])&&$_SESSION['server_error']==false)
									{
										$result = $portal->getSumOfChosenExpenses($connection,$_POST['begDate'],$_POST['endDate']);
									}
									elseif(isset($_SESSION['lastMonth'])&&$_SESSION['lastMonth']==true)
									{
										$result = $portal->getSumOfChosenExpenses($connection,date('Y-m-d', strtotime('last month')),date('Y-m-d'));
									}
									else
									{
										$result = $portal->getSumOfAllExpenses($connection);
									}
								if($_SESSION['server_error']==false)
								{
									$sumE=$result->fetch_all();
									echo $sumE[0][0];
								}
							?>
							</td>
							<td></td>
							<td>to za dużo</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-6 col-lg-5">
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
								$connection = @new mysqli($host,$db_user,$db_password,$db_name);
								@$connection -> query ('SET NAMES utf8');
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
									
									//if dates were chosen get incomes from period
									if(isset($_POST['begDate'])&&isset($_POST['endDate']))
									{
										$result = $portal->getChosenIncomes($connection,$_POST['begDate'],$_POST['endDate']);
									}
									//if last month were chosen get incomes from last month
									elseif(isset($_SESSION['lastMonth'])&&$_SESSION['lastMonth']==true)
									{
										$result = $portal->getChosenIncomes($connection,date('Y-m-d', strtotime('last month')),date('Y-m-d'));
									}
									//take everything by default
									else
									{
										$result = $portal->getAllIncomes($connection);
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
											echo '<td><form class="delete" action="index.php?action=delete_income" method="post"><input type="hidden" name="income_id" value="'.$income[0].'"><input class="delete delete-button" type="submit" name="delete" value="X"></form></td>';
										echo'</tr>';
									}
								}
							}
						
							catch(Exception $error)
							{
								echo "Błąd serwera!";
								$_SESSION['server_error']=true;
							}
						?>
						<tr>
							<td>Razem</td>
							<td>
							<?PHP
								//other sum for each case (compare above)
								if(isset($_POST['begDate'])&&isset($_POST['endDate'])&&$_SESSION['server_error']==false)
									{
										$result = $portal->getSumOfChosenIncomes($connection,$_POST['begDate'],$_POST['endDate']);
									}
									elseif(isset($_SESSION['lastMonth'])&&$_SESSION['lastMonth']==true)
									{
										$_SESSION['lastMonth']=false;
										$result = $portal->getSumOfChosenIncomes($connection,date('Y-m-d', strtotime('last month')),date('Y-m-d'));
									}
									else
									{
										$result = $portal->getSumOfAllIncomes($connection);
									}
								if($_SESSION['server_error']==false)
								{
									$sumI=$result->fetch_all();
									echo $sumI[0][0];
								}
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
						if($_SESSION['server_error']==false)
						{
							echo $sumI[0][0]-$sumE[0][0];
						}
					?>
				</h2>
			</div>
		</main>
	<?php endif ?>
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