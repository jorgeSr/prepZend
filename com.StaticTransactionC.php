<?php
	require_once('pojos/StaticTransaction.php');
	
	class StaticTransactionC{
		
		public function hello(){
			return "hello";
		}
		
		public function create(){
			return false;
		}
		
		public function update(){
			return false;
		}
		
		public function delete(){
			return false;
		}
		
		public function findAllByPeriodID(){
			return false;
		}
	}
?>