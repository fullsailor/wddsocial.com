<?php

namespace Framework5;

/*
* WDDSocialApplication controller
* 
* 
* @author tmatthews (tmatthewsdev@gmail.com)
*/

final class WDDSocialApplication extends ApplicationBase implements IApplication {
	
	/**
	* Execute a request. Called by the front controller.
	*/
	
	public function execute() {
		
		# init the application
		$this->init();
		
		# import packages in every request
		$this->global_import();
		
		# check user session
		import('wddsocial.controller.WDDSocial\UserSession');
		\WDDSocial\UserSession::init();
		
		# enable localization module
		$this->localize();
		
		# resolve request to a page controller
		import('wddsocial.config.WDDSocial\Router');
		$package = \WDDSocial\Router::resolve(Request::segment(0));
		
		# execute the controller
		execute($package);
		
		$_SESSION['last_request'] = Request::uri();
		
		return true;
	}
	
	
	
	/**
	* Initialize the application
	*/
	
	private function init() {
		
		# import application settings
		import('wddsocial.config.WDDSocial\AppSettings');
		
		# load package aliases
		PackageManager::define_alias_array(\WDDSocial\AppSettings::$package_aliases);
		
	}
	
	
	
	/**
	*  import application global dependencies
	*/
	
	private function global_import() {
		
		import('wddsocial.controller.WDDSocial\Exception');
		import('wddsocial.controller.WDDSocial\Validator');
		import('wddsocial.controller.WDDSocial\UserValidator');
		import('wddsocial.helper.WDDSocial\NaturalLanguage');
		import('wddsocial.helper.WDDSocial\StringCleaner');
		import('wddsocial.controller.WDDSocial\Formatter');
		import('wddsocial.sql.WDDSocial\SelectorSQL');
		import('wddsocial.controller.WDDSocial\Paginator');
		import('wddsocial.controller.WDDSocial\Hash');
		
	}
	
	
	
	private function localize() {
		import('core.module.i18n.Framework5\Lang');
		if (\WDDSocial\UserSession::is_authorized()) {
			Lang::language(\WDDSocial\UserSession::user_lang());
		}
		else {
			Lang::language(\WDDSocial\UserSession::visitor_lang());
		}
	}
	
	
	
	/**
	* Exception handler
	* 
	* @param Exception e
	*/
	
	public static function exception_handler($e) {
		
		# log_error defined in Controller
		if (\Framework5\Settings::$log_exception) \Framework5\Logger::log_exception($e);
		
		# display the error page
		$content = render('wddsocial.view.page.WDDSocial\ErrorView', $e);
		
		echo render(':template', 
			array('title' => 'an error has occured', 'content' => $content));
		
		die; # kill script execution
	}
}