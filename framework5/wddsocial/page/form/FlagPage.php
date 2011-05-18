<?php

namespace WDDSocial;

/*
* 
* Author: Anthony Colangelo (me@acolangelo.com)
*/

class FlagPage implements \Framework5\IExecutable {
	
	public function execute() {
		UserSession::protect();
		
		$this->db = instance(':db');
		$this->sel = instance(':sel-sql');
		$this->val = instance(':val-sql');
		$this->admin = instance(':admin-sql');
		
		$types = array('project','article','event','job');
		$type = \Framework5\Request::segment(1);
		$vanityURL = \Framework5\Request::segment(2);
		if (!in_array($type, $types) or !isset($vanityURL))
			redirect('/');
		
		switch ($type) {
			case 'project':
				$query = $this->db->prepare($this->sel->getProjectByVanityURL);
				break;
			case 'article':
				$query = $this->db->prepare($this->sel->getArticleByVanityURL);
				break;
			case 'event':
				$query = $this->db->prepare($this->sel->getEventByVanityURL);
				break;
			case 'job':
				$query = $this->db->prepare($this->sel->getJobByVanityURL);
				break;
			default:
				redirect('/');
				break;
		}
		$query->execute(array('vanityURL' => $vanityURL));
		
		import('wddsocial.model.WDDSocial\ContentVO');
		
		if ($query->rowCount() > 0) {
			$query->setFetchMode(\PDO::FETCH_CLASS,'WDDSocial\ContentVO');
			$content = $query->fetch();
			
			$data = array('id' => $content->id, 'userID' => UserSession::userid());
			
			switch ($type) {
				case 'project':
					$query = $this->db->prepare($this->val->isUserProjectCreator);
					break;
				case 'article':
					$query = $this->db->prepare($this->val->isUserArticleCreator);
					break;
				case 'event':
					$query = $this->db->prepare($this->val->isUserEventCreator);
					break;
				case 'job':
					$query = $this->db->prepare($this->val->isUserJobCreator);
					break;
			}
			$query->execute($data);
			
			if ($query->rowCount() > 0) {
				redirect('/');
			}
			else {
				switch ($type) {
					case 'project':
						$query = $this->db->prepare($this->val->checkIfProjectHasBeenFlagged);
						break;
					case 'article':
						$query = $this->db->prepare($this->val->checkIfArticleHasBeenFlagged);
						break;
					case 'event':
						$query = $this->db->prepare($this->val->checkIfEventHasBeenFlagged);
						break;
					case 'job':
						$query = $this->db->prepare($this->val->checkIfJobHasBeenFlagged);
						break;
				}
				$query->execute($data);
				
				if ($query->rowCount() > 0) {
					switch ($type) {
						case 'project':
							$query = $this->db->prepare($this->admin->unflagProject);
							break;
						case 'article':
							$query = $this->db->prepare($this->admin->unflagArticle);
							break;
						case 'event':
							$query = $this->db->prepare($this->admin->unflagEvent);
							break;
						case 'job':
							$query = $this->db->prepare($this->admin->unflagJob);
							break;
					}
					$query->execute($data);
				}
				else {
					switch ($type) {
						case 'project':
							$query = $this->db->prepare($this->admin->flagProject);
							break;
						case 'article':
							$query = $this->db->prepare($this->admin->flagArticle);
							break;
						case 'event':
							$query = $this->db->prepare($this->admin->flagEvent);
							break;
						case 'job':
							$query = $this->db->prepare($this->admin->flagJob);
							break;
					}
					$query->execute($data);
				}
				redirect('/');
			}
		}
		else {
			redirect('/');
		}
	}
}