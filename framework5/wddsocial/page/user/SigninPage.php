<?php

namespace WDDSocial;

/*
* 
* @author tmatthews (tmatthewsdev@gmail.com)
*/

class SigninPage implements \Framework5\IExecutable {
	
	public static function execute() {
		
		if(isset($_POST['email']) && isset($_POST['password'])){
			static::process_form();
		}else{
			# display site header
			echo render('wddsocial.view.TemplateView', array('section' => 'top', 'title' => 'Sign In'));
			
			# open content section
			echo render('wddsocial.view.SectionView', array('section' => 'begin_content'));
			
			# display sign in form
			echo render('wddsocial.view.FormView', array('type' => 'sign_in'));
			
			# end content section
			echo render('wddsocial.view.SectionView', array('section' => 'end_content'));
			
			# display site footer
			echo render('wddsocial.view.TemplateView', array('section' => 'bottom'));
		}
	}
	
	public static function process_form(){
		# display site header
		echo render('wddsocial.view.TemplateView', array('section' => 'top', 'title' => 'Sign In'));
		
		# open content section
		echo render('wddsocial.view.SectionView', array('section' => 'begin_content'));
		
		echo render('wddsocial.view.SectionView', array('section' => 'begin_content_section', 'id' => 'details', 'classes' => array('small'), 'header' => 'User Details'));
		
		echo <<<HTML

				<p>Email: {$_POST['email']}</p>
				<p>Password: {$_POST['password']}</p>
HTML;
				
		# Create section footer
		echo render('wddsocial.view.SectionView', array('section' => 'end_content_section', 'id' => 'details'));
		
		# end content section
		echo render('wddsocial.view.SectionView', array('section' => 'end_content'));
		
		# display site footer
		echo render('wddsocial.view.TemplateView', array('section' => 'bottom'));
	}
}