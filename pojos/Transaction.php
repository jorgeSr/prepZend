<?php
	class Transaction {
	     public $id;
	     public $userId;
	     public $categoryId;
	     public $periodId;
	     public $type;
	     public $date;
	     public $amount;
	     public $detail;
	     public $isStatic;
	     //public $childId; //Si no tiene -1 en DB
	}
?>