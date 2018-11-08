<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>finanse</title>
	<meta name="description" content="strona służąca porządkowaniu finansów osobistych" />
	<meta name="keywords" content="bilans, finanse, wydatki" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="author" content="Tomasz Kazek" />
	
	<!--bootstrap-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
	<!--css-->
	<link rel="stylesheet" href="style.css" type="text/css"/>
	
	<script src='https://www.google.com/recaptcha/api.js'></script>	
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
				<form action="finanse-osobiste?action=register" method="post">
				
					<a class="x" href="finanse-osobiste">X</a>
				
					<?php
						if(isset($_SESSION['err_login']))
						{
							echo '<div class="warning">'.$_SESSION['err_login'].'</div>';
							//clear error after display
							unset($_SESSION['err_login']);
						}
					?>

					<input type="text" name="login" placeholder="login" value=
						"<?php
							if(isset($_SESSION['keep_login']))
							{
								echo $_SESSION['keep_login'];
								//clear previous value
								unset($_SESSION['keep_login']);
							}
						?>"
					onfocus="this.placeholder=''" onblur="this.placeholder='login'">
					
					<?php
						if(isset($_SESSION['err_email']))
						{
							echo '<div class="warning">'.$_SESSION['err_email'].'</div>';
							//clear error after display
							unset($_SESSION['err_email']);
						}
					?>
					
					<input type="email" name="email" placeholder="email" value=
						"<?php
							if(isset($_SESSION['keep_email']))
							{
								echo $_SESSION['keep_email'];
								//clear previous value
								unset($_SESSION['keep_email']);
							}
						?>"			
					onfocus="this.placeholder=''" onblur="this.placeholder='email'">
					
					<?php
						if(isset($_SESSION['err_password']))
						{
							echo '<div class="warning">'.$_SESSION['err_password'].'</div>';
							//clear error after display
							unset($_SESSION['err_password']);
						}
					?>
					
					<input type="password" name="password1" placeholder="hasło" value=
						"<?php
							if(isset($_SESSION['keep_password1']))
							{
								echo $_SESSION['keep_password1'];
								//clear previous value
								unset($_SESSION['keep_password1']);
							}
						?>"					
					onfocus="this.placeholder=''" onblur="this.placeholder='hasło'">
					
					<?php
						if(isset($_SESSION['err_different']))
						{
							echo '<div class="warning">'.$_SESSION['err_different'].'</div>';
							//clear error after display
							unset($_SESSION['err_different']);
						}
					?>
					
					<input type="password" name="password2" placeholder="potwierdź hasło" value=
						"<?php
							if(isset($_SESSION['keep_password2']))
							{
								echo $_SESSION['keep_password2'];
								//clear previous value
								unset($_SESSION['keep_password2']);
							}
						?>"	
					
					onfocus="this.placeholder=''" onblur="this.placeholder='potwierdź hasło'">			
					<?php
						if(isset($_SESSION['err_captcha']))
						{
							echo '<div class="warning">'.$_SESSION['err_captcha'].'</div>';
							//clear error after display
							unset($_SESSION['err_captcha']);
						}
					?>
					
					<!--<div class="g-recaptcha" data-sitekey="6LfPQ2wUAAAAADKr-UZ3uWBL0dUwyW4DroLbLh-G"></div>--> <!--localhost-->
					<div class="g-recaptcha" data-sitekey="6Ld8KW8UAAAAAKdnXR89m511TVVbhkjeLqwiZI-j"></div> <!--server-->
					
					<input type="submit" value="Zarejestruj">
				
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