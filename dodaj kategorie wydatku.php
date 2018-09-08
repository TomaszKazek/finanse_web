<?php
	session_start();
	
	//bd credentials
	require_once"kontakt_z_baza.php";
	
	//redirect to logging if not logged
	if(!isset($_SESSION['logged']))
	{
		header('Location: logowanie.php');
		exit();
	}
	
	//do if form was submitted
	if(isset($_POST['category']))
	{
		//convert signs allowing sql injection
		$_POST['category']=htmlentities($_POST['category'],ENT_QUOTES,"UTF-8");
		
		try
		{
			//variables defined in kontakt_baza.php
			//@ to not show worning when host not found
			$connection = new mysqli($host,$db_user,$db_password,$db_name);
			//polish signs
			$connection -> query ('SET NAMES utf8');
			//if connection set up successfully ->else if not throw exception
			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$categoryExists=false;
				$categoryAssignedToUser=false;
				$result=$connection->query("SELECT * FROM expenses_categories WHERE expense_category='{$_POST['category']}'");
				
				if(!$result) throw new Exception($connection->error);
				
				$categories=$result->num_rows;
				
				//if enetered category exist in expenses_categories...
				if($categories==1)
				{
					//...mark it in $categoryExists...
					$categoryExists=true;
					$categoryID=$result->fetch_all();
					//...take its id...
					$categoryID=$categoryID[0][0];
					//check if attached to logged user
					$result=$connection->query("SELECT * FROM users_expenses_categories WHERE user_id={$_SESSION['user']}");
					if(!$result) throw new Exception($connection->error);
					$categories=$result->num_rows;
					//if so mark it
					if($categories==1)
					{
						$categoryAssignedToUser=true;
						$_SESSION['err']="Podana kategoria już istnieje!";
					}
				}
				
				//if category doesn't exist - add it
				if($categoryExists==false)
				{
					if($connection->query("INSERT INTO expenses_categories VALUES (NULL,'{$_POST['category']}')"))
					{	
						//take number just added category
						$result=$connection->query("SELECT * FROM expenses_categories WHERE expense_category='{$_POST['category']}'");
						$categoryID=$result->fetch_all();
						$categoryID=$categoryID[0][0];
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				
				if($categoryAssignedToUser==false)
				{
					//assign category to user and go to bilans
					if($connection->query("INSERT INTO users_expenses_categories VALUES ({$_SESSION['user']},$categoryID)"))
					{
						header('Location: bilans.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				
				unset($_POST['category']);
			}
		}
	
		catch(Exception $error)
			{
				$_SESSION['err']="Błąd serwera!";
			}
	}
?>

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
					<h1>Finan<span class="dolar">$€</span> o<span class="dolar">$</span>obi<span class="dolar">$</span>t<span class="dolar">€</span></h1>
				</div>
			</header>
			<div class="row col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 justify-content-center">
				<form method="post">
				
					<?php
						if(isset($_SESSION['err']))
						{
							echo '<div class="warning">'.$_SESSION['err'].'</div>';
							//clear error after display
							unset($_SESSION['err']);
						}
					?>
					<?php
						if(isset($_SESSION['err2']))
						{
							echo '<div class="warning">'.$_SESSION['err2'].'</div>';
							//clear error after display
							unset($_SESSION['err2']);
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