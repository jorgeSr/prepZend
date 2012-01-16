<?php
	require_once('pojos/Period.php');
	
	class PeriodC{
		
		public function hello(){
			//THE SESION ID :)
			return UserC::getSessionId();
		}

		public function create(Period $period){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     		mysql_select_db(DATABASE_NAME);

			$query = "SELECT * FROM period WHERE ( (iniDate <= '".$period->iniDate."' AND endDate >= '".$period->iniDate."') OR (iniDate <= '".$period->endDate."' AND endDate >= '".$period->endDate."') OR (iniDate >= '".$period->iniDate."' AND endDate <= '".$period->endDate."') ) AND userId = ".UserC::getSessionId();		

		  	$result = mysql_query($query);
		 	$numero = mysql_num_rows($result);
	     	
			if($numero < 1)
			{
				$period->userId = UserC::getSessionId();
		   		$query = "INSERT INTO period(userId, iniDate, endDate) values (".$period->userId.",'".$period->iniDate."','".$period->endDate."')";		   
				mysql_query($query);
				$period->id = mysql_insert_id();
				mysql_close($mysql);	

				return $period;
			}
	     		else
			{
				//$row = mysql_fetch_array($result); $row['result']
				mysql_close($mysql);
				return "Las fechas se traslapan con ".$numero." periodos";
			}
			
		}
		

		public function update(Period $period){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     		mysql_select_db(DATABASE_NAME);
	     		
			$query = "SELECT * FROM period WHERE id != ".$period->id." AND ( (iniDate <= '".$period->iniDate."' AND endDate >= '".$period->iniDate."') OR (iniDate <= '".$period->endDate."' AND endDate >= '".$period->endDate."') OR (iniDate >= '".$period->iniDate."' AND endDate <= '".$period->endDate."') ) AND userId = ".UserC::getSessionId();		

		  	$result = mysql_query($query);
		 	$numero = mysql_num_rows($result);
	     	
			if($numero < 1)
			{
		   		$query = "UPDATE period SET iniDate='".$period->iniDate."', endDate='".$period->endDate."' WHERE id=".$period->id;
				mysql_query($query);
				mysql_close($mysql);

				return $period;
			}
			else
			{
				//$row = mysql_fetch_array($result); $row['result']
				mysql_close($mysql);
				return "Las fechas se traslapan con ".$numero." periodos";
			}
		}			

		public function remove(Period $period){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     		mysql_select_db(DATABASE_NAME);
			mysql_query("DELETE FROM transaction WHERE periodId =".$period->id);
			mysql_query("DELETE FROM period WHERE id =".$period->id);
			mysql_close($mysql);
			
			return $period;
		}

		public function findAll(){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     		mysql_select_db(DATABASE_NAME);
			$query = "SELECT * FROM period WHERE userId = ".UserC::getSessionId();	
			
		  	$result = mysql_query($query);
		 	//$numero = mysql_num_rows($result);
		     
		 	return $result;
		}

		public function getPeriodoActual($fecha){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     		mysql_select_db(DATABASE_NAME);

			$query = "SELECT * FROM period WHERE iniDate <= '".$fecha."' AND endDate >= '".$fecha."' AND userId = ".UserC::getSessionId();
		  	$result = mysql_query($query);
			return $result;
		}
	}
?>