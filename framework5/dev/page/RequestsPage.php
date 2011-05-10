<?php

namespace Framework5\Dev;

/*
* 
* @author tmatthews (tmatthewsdev@gmail.com)
*/

class RequestsPage implements \Framework5\IExecutable {
	
	public function execute() {
		
		echo "{requests page}<br/>";
		
		$requests = $this->get_requests();
		
		# showing the results
		while($row = $requests->fetch()) {
			$time = date("F j, Y, g:i a", $row->time);
			
		    echo "request id <a href=\"../request/{$row->id}\">{$row->id}</a> at $time uri [{$row->uri}] <br/>";
		}
	}
	
	
	public function get_requests($limit = 0, $page = 0) {
		
		# get the db object
		$db = instance('core.controller.Framework5\Database');
		
		$sql = "SELECT * FROM fw5_request_log ORDER BY id DESC";
		$query = $db->query($sql);
		
		# setting the fetch mode
		$query->setFetchMode(\PDO::FETCH_OBJ);
		
		return $query;
	}
}