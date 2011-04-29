<?php

namespace WDDSocial;

/*
* PDO Database controller
* @author tmatthews (tmatthewsdev@gmail.com)
*/

final class Database extends \PDO {
	
	public function __construct() {
         
        # call PDO construct
        parent::__construct("mysql:host=internal-db.s112587.gridserver.com;dbname=db112587_wddsocial", "db112587_social", "F(=yZ4JFSW}c2t1W");
		
		# set default attributes
		$this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}
}