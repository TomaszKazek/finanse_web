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
	if(isset($_POST['value']))
	{
		$_POST['comment']=htmlentities($_POST['comment'],ENT_QUOTES,"UTF-8");
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
				//change category name to number from expenses_categories
				$result = $connection->query("SELECT * FROM incomes_categories");
				$names=$result->fetch_all();
				$i=0;
				while(1)
				{
					if($names[$i][1]==$_POST['category'])
					{
						$category=$names[$i][0];
						break;
					}
					else
					{
						$i++;
					}
				}
				
				if($connection->query("INSERT INTO incomes VALUES (NULL,{$_SESSION['user']},{$category},'{$_POST['date']}',{$_POST['value']},'{$_POST['comment']}')"))
				{
					header('Location: bilans.php');
				}
				else
				{
					throw new Exception($connection->error);
				}
				unset($_POST['value']);
				unset($_POST['category']);
				unset($_POST['date']);
				unset($_POST['comment']);
			}
		}
	
		catch(Exception $error)
			{
				$_SESSION['err']="Błąd serwera";
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

					<input type="number" name="value" step="0.01" placeholder="0.00 PLN" onfocus="this.placeholder=''" onblur="this.placeholder='0.00 PLN'" required>
										
					<select name="category" required>
						<option disabled selected value="">kategoria</option>
						<?php
							//set connection
							$connection = @new mysqli($host,$db_user,$db_password,$db_name);
							//take categories for user
							$result = $connection->query("SELECT income_category_id FROM users_incomes_categories WHERE user_id = {$_SESSION['user']}");
							$rows=$result->fetch_all();
							//for polish signs
							$connection -> query ('SET NAMES utf8');
							//$connection -> query ('SET CHARACTER_SET utf8_polish_ci');
							//load categories names
							$result = $connection->query("SELECT * FROM incomes_categories");
							$names=$result->fetch_all();
							//for every category number found for user look for its name in $names
							foreach($rows as $row)
								{
									echo'<option>';
									$i=0;
									while(1)
									{
										if($names[$i][0]==$row[0])
										{
											echo $names[$i][1];
											break;
										}
										else
										{
											$i++;
										}
									}
									echo'</option>';
								}
						?>
					</select>
					
					<input type="date" name="date" required>
					
					<input type="text" name="comment" placeholder="komentarz" onfocus="this.placeholder=''" onblur="this.placeholder='komentarz'">
					
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