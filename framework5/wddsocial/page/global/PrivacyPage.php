<?php

namespace WDDSocial;

/*
* 
* @author tmatthews (tmatthewsdev@gmail.com)
*/

class PrivacyPage implements \Framework5\IExecutable {
	
	public function __construct() {
		$this->lang = new \Framework5\Lang('wddsocial.lang.page.global.PrivacyPageLang');
	}
	
	
	
	public function execute() {
		$content = " ";
		
		# display page
		echo render(':template', 
			array('title' => $this->lang->text('page-title'), 'content' => $content));
	}
}