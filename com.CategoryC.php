<?php
	require_once('pojos/Category.php');
	
	class CategoryC{
		
		public function hello(){
			//THE SESION ID :)
			return UserC::getSessionId();
		}
		
		public function create($category){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     	mysql_select_db(DATABASE_NAME);
	     	
	     	$category->userId = UserC::getSessionId();
		   	$query = "INSERT INTO category(userId, name, type, idealType, ideal, comment) values (".$category->userId.",'".$category->name."',".$category->type.",".$category->idealType.",".$category->ideal.",'".$category->comment."')";		   
			mysql_query($query);
			mysql_close($mysql);
		}
		

		public function update($category){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     	mysql_select_db(DATABASE_NAME);
	     	
		   	$query = "UPDATE category SET name='".$category->name."', type=".$category->type.", idealType=".$category->idealType.", ideal=".$category->ideal.", comment='".$category->comment."' 
					WHERE id=".$category->id;
			mysql_query($query);
			mysql_close($mysql);
		}			

		public function findAll(){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     	mysql_select_db(DATABASE_NAME);
			$query = "SELECT * FROM category WHERE userId = ".UserC::getSessionId();	
		    $result = mysql_query($query);
		    $numero = mysql_num_rows($result);
		     
		    if($numero != 0)
		    {
		    	return $result;
		    }
		     
				return false;
		}
		
	}
?>