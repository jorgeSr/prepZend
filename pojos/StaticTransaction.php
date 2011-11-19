<?php
	require_once('Transaction.php');

	class StaticTransaction extends Transaction {
		public $idST;
		public $comment;
		public $done;
		public $variation;
		public $extra;
	}
?>