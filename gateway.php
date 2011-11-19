<?php 
	require_once('Zend/Amf/Server.php');
	require_once('Zend/Session/Namespace.php');
	require_once('Zend/Registry.php');
	
	require_once('DBdata.php');
	require_once('com.CategoryC.php');
	require_once('com.PeriodC.php');
	require_once('com.TransactionC.php');
	require_once('com.StaticTransactionC.php');
	require_once('com.UserC.php');

	
	$session = new Zend_Session_Namespace("my_session");
	Zend_Registry::set("session", $session);
	  
	$server = new Zend_Amf_Server();

	$server->setClass("CategoryC","categoryC")
		->setClass("PeriodC","periodC")
		->setClass("TransactionC","transactionC")
		->setClass("StaticTransactionC","staticTransaction")
		->setClass("UserC","userC");
		
	$server->setClassMap("Category", "Category")
		->setClassMap("Period", "Period")
		->setClassMap("Transaction","Transaction")
		->setClassMap("User", "User");
	
	echo($server->handle());
?>