<?php
	require_once('pojos/Category.php');
	
	class CategoryC{
		
		public function hello(){
			//THE SESION ID :)
			return UserC::getSessionId();
		}
		
		public function create(Category $category){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     	mysql_select_db(DATABASE_NAME);
	     	
	     	$category->userId = UserC::getSessionId();
		   	$query = "INSERT INTO category(userId, name, type, idealType, ideal, comment) values (".$category->userId.",'".$category->name."',".$category->type.",".$category->idealType.",".$category->ideal.",'".$category->comment."')";		   
			mysql_query($query);
			mysql_close($mysql);
		}
		

		public function update(Category $category){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     	mysql_select_db(DATABASE_NAME);
	     	
		   	$query = "UPDATE category SET name='".$category->name."', type=".$category->type.", idealType=".$category->idealType.", ideal=".$category->ideal.", comment='".$category->comment."' 
					WHERE id=".$category->id;
			mysql_query($query);
			mysql_close($mysql);
		}	

		public function remove(Category $category){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
		     	mysql_select_db(DATABASE_NAME);
			mysql_query("DELETE FROM transaction WHERE categoryId =".$category->id);
			mysql_query("DELETE FROM category WHERE id =".$category->id);
			mysql_close($mysql);
			return $category;
		}		

		public function findAll(){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
		     	mysql_select_db(DATABASE_NAME);
			$query = "SELECT * FROM category WHERE userId = ".UserC::getSessionId();	
			
			$result = mysql_query($query);
			return $result;
		}
		
		public function findByType($type){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
		     	mysql_select_db(DATABASE_NAME);
			$query = "SELECT * FROM category WHERE type=".$type." AND userId = ".UserC::getSessionId();	
			
			$result = mysql_query($query);
			return $result;
		}

	}
?>