<?php

namespace WDDSocial;

/*
* 
* @author Anthony Colangelo (me@acolangelo.com)
* @author tmatthews (tmatthewsdev@gmail.com)
*/

class PeoplePage implements \Framework5\IExecutable {
	
	public function __construct() {
		$this->db = instance(':db');
		$this->sql = instance(':sel-sql');
	}
	
	
	
	public function execute() {
		import('wddsocial.model.WDDSocial\UserVO');
		
		# page title
		$page_title = 'People';
		
		$content = render(':section', array('section' => 'begin_content'));
		
		$sorter = \Framework5\Request::segment(2);
		$sorters = array('alphabetically', 'newest', 'oldest');
		
		if (isset($sorter) and in_array($sorter, $sorters)) $active = $sorter;
		else $active = $sorters[0];
		
		$content.= render(':section', 
			array('section' => 'begin_content_section', 'id' => 'directory', 
				'classes' => array('mega', 'with-secondary'), 
				'header' => 'People', 'sort' => true, 'sorters' => $sorters, 'base_link' => '/people/1/', 'active' => $active));
		
		$paginator = new Paginator(1,18);
		
		switch ($active) {
			case 'alphabetically':
				$orderBy = 'lastName ASC';
				break;
			
			case 'newest':
				$orderBy = '`datetime` DESC';
				break;
			
			case 'oldest':
				$orderBy = '`datetime` ASC';
				break;
			
			default:
				$orderBy = 'lastName ASC';
				break;
		}
		
		# query
		$query = $this->db->prepare($this->sql->getPeople . " ORDER BY $orderBy" . " LIMIT 0, {$paginator->limit}");
		$query->execute(array('orderBy' => $orderBy));
		$query->setFetchMode(\PDO::FETCH_CLASS,'WDDSocial\UserVO');
		
		# display section items
		while($item = $query->fetch()){
			$content.= render('wddsocial.view.content.WDDSocial\DirectoryUserItemView', 
				array('content' => $item));
		}
		
		
		$query = $this->db->prepare($this->sql->getPeople . " ORDER BY $orderBy" . " LIMIT {$paginator->limit}, {$paginator->per}");
		$query->execute();
		$query->setFetchMode(\PDO::FETCH_OBJ);
		$query->fetch();
		
		
		if ($query->rowCount() > 0) {
			# display section footer
			$content.= render(':section',
				array('section' => 'end_content_section', 'id' => 'directory', 'load_more' => 'posts', 'load_more_link' => "/people/{$paginator->next}/$active"));	
		}		
		else {
			# display section footer
			$content.= render(':section',
				array('section' => 'end_content_section', 'id' => 'directory'));	
		}
		
		$content.= render(':section', array('section' => 'end_content'));
		
		# display page
		echo render('wddsocial.view.global.WDDSocial\SiteTemplate', 
			array('title' => $page_title, 'content' => $content));
		
	}
}