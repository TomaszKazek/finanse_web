<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
	
	<main>
		<div class="container-fluid">
			<header class="row">
				<div class="col-sm-12">
					<a class="logo" href="finanse-osobiste">
						<h1>Finan<span class="dolar">$€</span> o<span class="dolar">$</span>obi<span class="dolar">$</span>t<span class="dolar">€</span></h1>
					</a>
				</div>
			</header>
			<div class="row col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 justify-content-center">
				<form action="index.php?action=addExpenseCategory" method="post">
				
					<a class="x" href="finanse-osobiste">X</a>
				
					<?php
						if(isset($_SESSION['err']))
						{
							echo '<div class="warning">'.$_SESSION['err'].'</div>';
							//clear error after display
							unset($_SESSION['err']);
						}
					?>

					<input type="text" name="category" placeholder="kategoria" onfocus="this.placeholder=''" onblur="this.placeholder='kategoria'">
					
					<input type="submit" value="Dodaj">
				
				</form>
			</div>
		</div>
	</main>
	
<!--bootstrap-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>