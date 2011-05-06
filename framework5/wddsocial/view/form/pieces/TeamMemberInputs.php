<?php

namespace WDDSocial;

/*
* 
* @author Anthony Colangelo (me@acolangelo.com)
*/

class TeamMemberInputs implements \Framework5\IView {		
	
	public static function render($options = null) {
		$db = instance(':db');
		$sql = instance(':sel-sql');
		
		$query = $db->query($sql->getThreeRandomUsers);
		$query->setFetchMode(\PDO::FETCH_OBJ);
		$users = $query->fetchAll();
		
		$query = $db->query($sql->getThreeRandomRoles);
		$query->setFetchMode(\PDO::FETCH_OBJ);
		$roles = $query->fetchAll();
		
		$singular = rtrim($options['header'],'s');
		
		$html = <<<HTML

						<h1 id="team">{$options['header']}</h1>
HTML;
		if ($options['type'] != 'project') {
			$html .= <<<HTML

						<fieldset>
HTML;
		}
		for ($i = 1; $i < 4; $i++) {
			if ($options['type'] == 'project') {
				$html .= <<<HTML

						<fieldset>
							<label for="team$i">$singular $i</label>
							<input type="text" name="team[]" id="team$i" placeholder="{$users[$i-1]->name}" />
							
							<label for="role$i">Project Role</label>
							<input type="text" name="roles[]" id="role$i" placeholder="{$roles[$i-1]->title}" />
						</fieldset>
HTML;
			}
			else {
				$html .= <<<HTML

							<input type="text" name="team[]" id="team$i" />
HTML;
			}
		}
		if ($options['type'] != 'project') {
			$html .= <<<HTML

						</fieldset>
HTML;
		}
		$html .= <<<HTML

						<a href="#" title="Add Another $singular" class="add-more">Add Another $singular</a>
HTML;
		return $html;
	}
}