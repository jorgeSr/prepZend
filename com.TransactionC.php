<?php
	require_once('pojos/Transaction.php');
	
	class TransactionC{
		
		public function hello(){
			//THE SESION ID :)
			return UserC::getSessionId();
		}
		
		public function create(Transaction $t){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     		mysql_select_db(DATABASE_NAME);	     	

	     		$t->userId = UserC::getSessionId();
		   	$query = "INSERT INTO transaction(userId, categoryId, periodId, type, date, amount, detail) values (".$t->userId.",".$t->categoryId.",".$t->periodId.",".$t->type.",'".$t->date."',".$t->amount.",'".$t->detail."')";		   

			mysql_query($query);
			mysql_close($mysql);

			return $t;
		}
		

		public function update(Transaction $t){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     		mysql_select_db(DATABASE_NAME);
	     	
		   	$query = "UPDATE transaction SET categoryId ='".$t->categoryId."', type=".$t->type.", date ='".$t->date."', amount =".$t->amount.", detail='".$t->detail."'
					WHERE id=".$transaction->id;
			mysql_query($query);
			mysql_close($mysql);

			return $transaction;
		}			

		public function findAll(){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     		mysql_select_db(DATABASE_NAME);
			$query = "SELECT * FROM transaction WHERE userId = ".UserC::getSessionId();	
			
		    	$result = mysql_query($query);
		    	return $result;
		}
	}
?>