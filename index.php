<?php
	require_once "Portal.php";
	session_start();
	
	$portal=new Portal();
	
	$action = "";
	if (isset($_GET['action']))
	{
		$action=$_GET['action'];
	}

	switch($action)
	{
		case 'showLoginForm':
			include 'logowanie.php';
			break;
		case 'login':
			$portal->login($_POST['login'],$_POST['password']);
			break;
		case 'logout':	
			$portal->logout();
			break;
		case 'showRegistrationForm':
			include 'rejestracja.php';
			break;
		case 'register':
			$portal->register($_POST['login'],$_POST['password1'],$_POST['password2'],$_POST['email']);
			break;
		case 'delete_expense':
			$portal->deleteExpense($_POST['expense_id']);
			break;
		case 'delete_income':
			$portal->deleteIncome($_POST['income_id']);
			break;
		case 'showAddIncomeCategoryForm':
			include 'dodaj kategorie przychodu.php';
			break;
		case 'addIncomeCategory':
			$portal->addIncomeCategory($_POST['category']);
			break;
		case 'showAddExpenseCategoryForm':
			include 'dodaj kategorie wydatku.php';
			break;
		case 'addExpenseCategory':
			$portal->addExpenseCategory($_POST['category']);
			break;
		case 'showDeleteIncomeCategoryForm':
			include 'usun kategorie przychodu.php';
			break;
		case 'deleteIncomeCategory':
			$portal->deleteIncomeCategory($_POST['category']);
			break;
		case 'showDeleteExpenseCategoryForm':
			include 'usun kategorie wydatku.php';
			break;
		case 'deleteExpenseCategory':
			$portal->deleteExpenseCategory($_POST['category']);
			break;
		case 'showAddExpenseForm':
			include 'dodaj wydatek.php';
			break;
		case 'addExpense':
			$portal->addExpense($_POST['category'],$_POST['date'],$_POST['value'],$_POST['comment']);
			break;
		case 'showAddIncomeForm':
			include 'dodaj przychod.php';
			break;
		case 'addIncome':
			$portal->addIncome($_POST['category'],$_POST['date'],$_POST['value'],$_POST['comment']);
			break;
		case 'showChangePasswordForm':
			include 'zmiana hasla.php';
			break;
		case 'changePassword':
			$portal->changePassword($_POST['password1'],$_POST['password2']);
			break;
		case 'chooseDates':
			include 'daty bilansu.php';
			break;
		case 'lastMonth':
			$_SESSION['lastMonth']=true;
			//no break here! and it have to be last case before default
		default:
			include 'main.php';
	}
?>