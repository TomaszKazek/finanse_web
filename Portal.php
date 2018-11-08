<?php
class Portal
{
	private $user;
	
	function __construct()
	{
		if(isset($_SESSION['user']))
		{
			$this->user=$_SESSION['user'];
		}
	}
	
	public function getUser()
	{
		return $this->user;
	}
	
	public function login($login,$password)
	{
		//bd credentials
		require_once "kontakt_z_baza.php";
		
		try
		{
			//variables defined in kontakt_baza.php
			//@ to not show worning when host not found
			$connection = @new mysqli($host,$db_user,$db_password,$db_name);
			
			//if connection set up successfully ->else if not throw exception
			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//convert signs allowing sql injection
				$login=htmlentities($login,ENT_QUOTES,"UTF-8");
				
				//do if connection works (failed connection give 0)
				if($result = $connection->query(
				//%s will be replaced by mysqli_real_escape_strings
				sprintf("SELECT * FROM users WHERE login='%s'",
				//prevents query errors (e.g. removes ' )
				mysqli_real_escape_string($connection,$login))))
				{
					$users=$result->num_rows;
					if($users==1)
					{
						//create tab with index from tab from database
						$row = $result->fetch_assoc();
						//compares hashed passwords
						if(password_verify($password,$row['user_password']))
						{
						$_SESSION['user']=$row['user_id'];
						$connection->close();
						unset($_SESSION['err_log']);
						unset($_SESSION['err_pass']);
						unset($_SESSION['keep_login']);
						header('Location: finanse-osobiste');
						}
						else
						{
						$_SESSION['err_pass']='<span class="warning">Nieprawidłowe hasło!</span>';
						$_SESSION['keep_login']=$login;
						header ('Location:finanse-osobiste?action=showLoginForm');
						}
					}
					else
					{
						$_SESSION['err_log']='<span class="warning">Niepoprawny login!</span>';
						header ('Location:finanse-osobiste?action=showLoginForm');
					}
				}
				else
				{
						throw new Exception($connection->error);
				}
				
				$connection->close();
			}
		}
		catch(Exception $error)
		{
			$_SESSION['err_log']='<span class="warning">Błąd serwera!</span>';
			header ('Location:finanse-osobiste?action=showLoginForm');
		}
	}
	
	public function logout()
	{
		session_unset();
		header ('Location:finanse-osobiste');
	}
	
	public function register($login,$password1,$password2,$email)
	{		
		//if already loggen on go to bilans
		if(isset($_SESSION['user']))
		{
			header('Location:finanse-osobiste');
			//skip following code
			exit();
		}
			
		//$ok stays true if all test passed
		$ok=true;
		
		if((strlen($login)<3)||(strlen($login)>20))
		{
			$ok=false;
			$_SESSION['err_login']="Login musi się składać z od 3 do 20 znaków";
		}
		
		if(ctype_alnum($login)==false)
		{
			$ok=false;
			$_SESSION['err_login']="Login musi się składać wyłącznie z liter i/lub cyfr (bez polskich znaków)";
		}
		
		//removes not allowed signs from mail entered
		$filter_email=filter_var($email,FILTER_SANITIZE_EMAIL);
		
		//fail if not allowed signs entered in mail
		if((filter_var($filter_email,FILTER_VALIDATE_EMAIL)==false)||($filter_email!=$email))
		{
			$ok=false;
			$_SESSION['err_email']="Adres email niepoprawny";
		}
		
		if ((strlen($password1)<3)||(strlen($password1)>40))
		{
			$ok=false;
			$_SESSION['err_password']="Hasło musi się składać z od 3 do 40 znaków";
		}
		
		if ($password1!=$password2)
		{
			$ok=false;
			$_SESSION['err_different']="Podano różne hasła";
		}
		
		$password=password_hash($password1,PASSWORD_DEFAULT);
		
		//captcha
		//$secret_key="6LfPQ2wUAAAAALg_8MoKkkbsCT248JM7e9Li8OFX"; //localhost
		$secret_key="6Ld8KW8UAAAAAFOiREtLuoGvgZP-Irl46ru1b1W5"; //server
		
		$check=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
		
		$response=json_decode($check);
		
		if($response->success==false)
		{
			$ok=false;
			$_SESSION['err_captcha']="Potwiedź, że nie jesteś botem";
		}
		
		$_SESSION['keep_login']=$login;
		$_SESSION['keep_email']=$email;
		$_SESSION['keep_password1']=$password1;
		$_SESSION['keep_password2']=$password2;
		
		//bd credentials
		//require_once"kontakt_z_baza.php";
		
		try
		{
			//variables defined in kontakt_baza.php
			//@ to not show worning when host not found
			$connection = @new mysqli($host,$db_user,$db_password,$db_name);
			//if connection set up successfully ->else if not throw exception
			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				/*$result=$connection->query("SELECT user_id FROM users WHERE email='$email'");
				
				if(!$result) throw new Exception($connection->error);
				
				$mails=$result->num_rows;
				if($mails==1)
				{
					$ok=false;
					$_SESSION['err_email']="Podany email jest przypisany do już istniejącego konta";
				}*/
				
				$result=$connection->query("SELECT user_id FROM users WHERE login='$login'");
				
				if(!$result) throw new Exception($connection->error);
				
				$users=$result->num_rows;
				if($users==1)
				{
					$ok=false;
					$_SESSION['err_login']="Podany login jest już zajęty";
				}
				
				if($ok==true)
				{
					if($connection->query("INSERT INTO users VALUES (NULL,'$login',NULL,'$password')"))
					{
						header('Location: finanse-osobiste');
						$result=$connection->query("SELECT expense_category_id FROM default_expenses_categories");
						$rows=$result->fetch_all();
						$result=$connection->query("SELECT user_id FROM users WHERE login='$login'");
						$user=$result->fetch_all();
						$user=$user[0];
						$user_id=$user[0];
						$query="INSERT INTO users_expenses_categories VALUES";
						foreach($rows as $row)
						{
							$query=$query."(".$user_id.",".$row[0]."),";
						}
						//delete "," at the end
						$query=substr($query,0,(strlen($query)-1));
						//insert default expenses categories to databse
						$connection->query($query);
						
						//the same for incomes
						$result=$connection->query("SELECT income_category_id FROM default_incomes_categories");
						$rows=$result->fetch_all();
						
						$query="INSERT INTO users_incomes_categories VALUES";
						foreach($rows as $row)
						{
							$query=$query."(".$user_id.",".$row[0]."),";
						}
						//delete "," at the end
						$query=substr($query,0,(strlen($query)-1));
						//insert default incomes categories to databse
						$connection->query($query);
						
						unset($_SESSION['keep_login']);
						unset($_SESSION['keep_email']);
						unset($_SESSION['keep_password1']);
						unset($_SESSION['keep_password2']);
						unset($_SESSION['err_login']);
						unset($_SESSION['err_email']);
						unset($_SESSION['err_password']);
						unset($_SESSION['err_different']);
						unset($_SESSION['err_captcha']);
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				else
				{
					header ('Location:finanse-osobiste?action=showRegistrationForm');
				}
				
				$connection->close();
			}
		}
		catch(Exception $error)
		{
			$_SESSION['err_login']="Błąd serwera";
			header ('Location:finanse-osobiste?action=showRegistrationForm');
		}
	}
	
	public function deleteExpense($expense_id)
	{
		//bd credentials
		require_once "kontakt_z_baza.php";
		
		//variables defined in kontakt_baza.php
		//@ to not show worning when host not found
		$connection = @new mysqli($host,$db_user,$db_password,$db_name);
		//polish signs
		$connection -> query ('SET NAMES utf8');
		$connection->query("DELETE FROM expenses WHERE expense_id={$expense_id}");
		header ('Location:finanse-osobiste');
	}
	
	public function deleteIncome($income_id)
	{
		//bd credentials
		require_once "kontakt_z_baza.php";
		
		//variables defined in kontakt_baza.php
		//@ to not show worning when host not found
		$connection = @new mysqli($host,$db_user,$db_password,$db_name);
		//polish signs
		$connection -> query ('SET NAMES utf8');
		$connection->query("DELETE FROM incomes WHERE income_id={$income_id}");
		header ('Location:finanse-osobiste');
	}
	
	public function getAllExpenses($connection)
	{
		@$output = $connection->query("SELECT * FROM expenses WHERE user_id={$this->user}");
		return $output;
	}
	
	public function getSumOfAllExpenses($connection)
	{
		@$output = $connection->query("SELECT SUM(value) FROM expenses WHERE user_id={$this->user}");
		return $output;
	}
	
	public function getChosenExpenses($connection,$begDate,$endDate)
	{
		@$output = $connection->query("SELECT * FROM expenses WHERE user_id={$this->user} AND date BETWEEN '{$begDate}' AND '{$endDate}' ");
		return $output;
	}
	
	public function getSumOfChosenExpenses($connection,$begDate,$endDate)
	{
		@$output = $connection->query("SELECT SUM(value) FROM expenses WHERE user_id={$this->user} AND date BETWEEN '{$begDate}' AND '{$endDate}' ");
		return $output;
	}
	
	public function getAllIncomes($connection)
	{
		@$output = $connection->query("SELECT * FROM incomes WHERE user_id={$this->user}");
		return $output;
	}
	
	public function getSumOfAllIncomes($connection)
	{
		@$output = $connection->query("SELECT SUM(value) FROM incomes WHERE user_id={$this->user}");
		return $output;
	}
	
	public function getChosenIncomes($connection,$begDate,$endDate)
	{
		@$output = $connection->query("SELECT * FROM incomes WHERE user_id={$this->user} AND date BETWEEN '{$begDate}' AND '{$endDate}' ");
		return $output;
	}
	
	public function getSumOfChosenIncomes($connection,$begDate,$endDate)
	{
		@$output = $connection->query("SELECT SUM(value) FROM incomes WHERE user_id={$this->user} AND date BETWEEN '{$begDate}' AND '{$endDate}' ");
		return $output;
	}
	
	public function addIncomeCategory ($category)
	{
		//bd credentials
		require_once"kontakt_z_baza.php";
		
		//convert signs allowing sql injection
		$category=htmlentities($category,ENT_QUOTES,"UTF-8");
		
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
				$result=$connection->query("SELECT * FROM incomes_categories WHERE income_category='{$category}'");
				
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
					$result=$connection->query("SELECT * FROM users_incomes_categories WHERE user_ID={$this->user} AND income_category_id={$categoryID}");
					if(!$result) throw new Exception($connection->error);
					$categories=$result->num_rows;
					//if so mark it
					if($categories==1)
					{
						$categoryAssignedToUser=true;
						$_SESSION['err']="Podana kategoria już istnieje!";
						header ('Location:finanse-osobiste?action=showAddIncomeCategoryForm');
					}
				}
				
				//if category doesn't exist - add it
				if($categoryExists==false)
				{
					if($connection->query("INSERT INTO incomes_categories VALUES (NULL,'{$category}')"))
					{	
						//take number just added category
						$result=$connection->query("SELECT * FROM incomes_categories WHERE income_category='{$category}'");
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
					if($connection->query("INSERT INTO users_incomes_categories VALUES ({$this->user},$categoryID)"))
					{
						header('Location: finanse-osobiste');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
			}
		}
	
		catch(Exception $error)
		{
			$_SESSION['err']="Błąd serwera!";
			header ('Location:finanse-osobiste?action=showAddIncomeCategoryForm');
		}
	}
	
	public function addExpenseCategory ($category)
	{
		//bd credentials
		require_once"kontakt_z_baza.php";
		
		//convert signs allowing sql injection
		$category=htmlentities($category,ENT_QUOTES,"UTF-8");
		
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
				$result=$connection->query("SELECT * FROM expenses_categories WHERE expense_category='{$category}'");
				
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
					$result=$connection->query("SELECT * FROM users_expenses_categories WHERE user_ID={$this->user} AND expense_category_id={$categoryID}");
					if(!$result) throw new Exception($connection->error);
					$categories=$result->num_rows;
					//if so mark it
					if($categories==1)
					{
						$categoryAssignedToUser=true;
						$_SESSION['err']="Podana kategoria już istnieje!";
						header ('Location:finanse-osobiste?action=showAddExpenseCategoryForm');
					}
				}
				
				//if category doesn't exist - add it
				if($categoryExists==false)
				{
					if($connection->query("INSERT INTO expenses_categories VALUES (NULL,'{$category}')"))
					{	
						//take number just added category
						$result=$connection->query("SELECT * FROM expenses_categories WHERE expense_category='{$category}'");
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
					if($connection->query("INSERT INTO users_expenses_categories VALUES ({$this->user},$categoryID)"))
					{
						header('Location: finanse-osobiste');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
			}
		}
	
		catch(Exception $error)
		{
			$_SESSION['err']="Błąd serwera!";
			header ('Location:finanse-osobiste?action=showAddExpenseCategoryForm');
		}
	}
	
	public function deleteIncomeCategory($category)
	{
		//bd credentials
		require_once"kontakt_z_baza.php";
		
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
				//change category name to number from incomes_categories
				$result = $connection->query("SELECT * FROM incomes_categories");
				$names=$result->fetch_all();
				$i=0;
				while(1)
				{
					if($names[$i][1]==$category)
					{
						$categoryID=$names[$i][0];
						break;
					}
					else
					{
						$i++;
					}
				}
				
				$incomeInDB=false;
				$result=$connection->query("SELECT * FROM incomes WHERE category_id='{$categoryID}' AND user_id={$this->user}");
				
				if(!$result) throw new Exception($connection->error);
				
				$incomes=$result->num_rows;
				
				//if there is income of chosen category
				if($incomes>0)
				{
					//...mark it in $incomeInDB...
					$incomeInDB=true;
					$_SESSION['err']="Nie można usunąć kategorii przypisanej do przychodu!";
					header('Location: finanse-osobiste?action=showDeleteIncomeCategoryForm');
				}
				
				//if income doesn't exist - delete category
				if($incomeInDB==false)
				{
					if($connection->query("DELETE FROM users_incomes_categories WHERE income_category_id='{$categoryID}'"))
					{	
						header('Location: finanse-osobiste');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
			}
		}
	
		catch(Exception $error)
			{
				$_SESSION['err']="Błąd serwera!";
				header('Location: finanse-osobiste?action=showDeleteIncomeCategoryForm');
			}
	}
	
	public function deleteExpenseCategory($category)
	{
		//bd credentials
		require_once"kontakt_z_baza.php";
		
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
				$result = $connection->query("SELECT * FROM expenses_categories");
				$names=$result->fetch_all();
				$i=0;
				while(1)
				{
					if($names[$i][1]==$category)
					{
						$categoryID=$names[$i][0];
						break;
					}
					else
					{
						$i++;
					}
				}
				
				$expenseInDB=false;
				$result=$connection->query("SELECT * FROM expenses WHERE category_id='{$categoryID}' AND user_id={$this->user}");
				
				if(!$result) throw new Exception($connection->error);
				
				$expenses=$result->num_rows;
				
				//if there is expense of chosen category
				if($expenses>0)
				{
					//...mark it in $incomeInDB...
					$expenseInDB=true;
					$_SESSION['err']="Nie można usunąć kategorii przypisanej do wydatku!";
					header('Location: finanse-osobiste?action=showDeleteExpenseCategoryForm');
				}
				
				//if expense doesn't exist - delete category
				if($expenseInDB==false)
				{
					if($connection->query("DELETE FROM users_expenses_categories WHERE expense_category_id='{$categoryID}'"))
					{	
						header('Location: finanse-osobiste');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
			}
		}
	
		catch(Exception $error)
			{
				$_SESSION['err']="Błąd serwera!";
				header('Location: finanse-osobiste?action=showDeleteExpenseCategoryForm');
			}
	}
	
	public function addExpense($category,$date,$value,$comment)
	{
		//bd credentials
		require_once"kontakt_z_baza.php";
		
		$comment=htmlentities($comment,ENT_QUOTES,"UTF-8");
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
				$result = $connection->query("SELECT * FROM expenses_categories");
				$names=$result->fetch_all();
				$i=0;
				while(1)
				{
					if($names[$i][1]==$category)
					{
						$categoryID=$names[$i][0];
						break;
					}
					else
					{
						$i++;
					}
				}
				
				if($connection->query("INSERT INTO expenses VALUES (NULL,{$this->user},{$categoryID},'{$date}',{$value},'{$comment}')"))
				{
					header('Location: finanse-osobiste');
				}
				else
				{
					throw new Exception($connection->error);
				}
			}
		}
	
		catch(Exception $error)
		{
			$_SESSION['err']="Błąd serwera";
			header('Location: finanse-osobiste?action=showAddExpenseForm');
		}
	}
	
	public function addIncome($category,$date,$value,$comment)
	{
		//bd credentials
		require_once"kontakt_z_baza.php";
		
		$comment=htmlentities($comment,ENT_QUOTES,"UTF-8");
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
				//change category name to number from incomes_categories
				$result = $connection->query("SELECT * FROM incomes_categories");
				$names=$result->fetch_all();
				$i=0;
				while(1)
				{
					if($names[$i][1]==$category)
					{
						$categoryID=$names[$i][0];
						break;
					}
					else
					{
						$i++;
					}
				}
				
				if($connection->query("INSERT INTO incomes VALUES (NULL,{$this->user},{$categoryID},'{$date}',{$value},'{$comment}')"))
				{
					header('Location: finanse-osobiste');
				}
				else
				{
					throw new Exception($connection->error);
				}
			}
		}
	
		catch(Exception $error)
		{
			$_SESSION['err']="Błąd serwera";
			header('Location: finanse-osobiste?action=showAddIncomeForm');
		}
	}
	
	public function changePassword ($password1,$password2)
	{
		//bd credentials
		require_once "kontakt_z_baza.php";
		
		//$ok stays true if all test passed
		$ok=true;
		
		if ((strlen($password1)<3)||(strlen($password1)>40))
		{
			$ok=false;
			$_SESSION['err_password']="Hasło musi się składać z od 3 do 40 znaków";
			header ('Location:finanse-osobiste?action=showChangePasswordForm');
		}
		
		if ($password1!=$password2)
		{
			$ok=false;
			$_SESSION['err_different']="Podano różne hasła";
			header ('Location:finanse-osobiste?action=showChangePasswordForm');
		}
		
		$password=password_hash($password1,PASSWORD_DEFAULT);
		
		try
		{
			//variables defined in kontakt_baza.php
			//@ to not show worning when host not found
			$connection = @new mysqli($host,$db_user,$db_password,$db_name);
			//if connection set up successfully ->else if not throw exception
			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				if($ok==true)
				{
					if($connection->query("UPDATE users SET user_password='$password' WHERE user_id={$this->user}"))
					{
						header('Location: finanse-osobiste');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				
				$connection->close();
			}
		}
		catch(Exception $error)
		{
			$_SESSION['err_password']="Błąd serwera";
			header('Location: finanse-osobiste?action=showChangePasswordForm');
		}
	}
}
?>