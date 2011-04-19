<?php

namespace WDDSocial;

/*
* PDO Database controller
* @author tmatthews (tmatthewsdev@gmail.com)
*/

final class Database extends \PDO {
	
	public function __construct() {
		
		# call PDO construct
		
		# set default attributes
		$this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}
}