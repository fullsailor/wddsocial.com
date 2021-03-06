<?php

namespace WDDSocial;

/*
* 
* @author Anthony Colangelo (me@acolangelo.com)
*/

class SectionView implements \Framework5\IView {
	
	
	public function __construct() {
		$this->lang = new \Framework5\Lang('wddsocial.lang.view.global.SectionViewLang');
	}
	
	
	/**
	* Determines what type of content to render
	*/
	
	public function render($options = null) {
		
		# retrieve content based on the provided section
		switch ($options['section']) {
			case 'begin_content':
				return static::begin_content($options);
			case 'end_content':
				return static::end_content();
			case 'begin_content_section':
				return static::begin_content_section($options);
			case 'end_content_section':
				return static::end_content_section($options);
			default:
				throw new Exception("SectionView requires parameter section (content or content_section), '{$options['section']}' provided");
		}
	}
	
	
	
	/**
	* Opens main content section, with optional classes
	*/
	
	private function begin_content($options){
		if(count($options['classes']) > 0){
			$classString = implode(' ', $options['classes']);
			return <<<HTML

			<section id="content" class="$classString">
HTML;
		}else{
			return <<<HTML

			<section id="content">
HTML;
		}
	}
	
	
	
	/**
	* Ends main content section
	*/
	
	private function end_content(){	
		return <<<HTML

			</section><!-- END CONTENT -->
HTML;
	}
	
	
	
	# Opens subcontent section, with optional classes, extras
	private function begin_content_section($options){
		if (!isset($options['id']) or !isset($options['header']))
			throw new Exception("SectionView begin_content_setion requires parameter id (section ID) and header (h1 text)");
		
		if (count($options['classes']) > 0)
			$classString = implode(' ', $options['classes']);
			
		if ($options['sort'])
			$extras = $this->sorters($options['sorters'], $options['active'], $options['base_link']);
		
		if (isset($options['extra'])) {
			$extras = $this->get_extra($options['extra']);
		}
		
		return <<<HTML

				<section id="{$options['id']}" class="$classString">
					<h1>{$options['header']}</h1>
					$extras
HTML;
	}
	
	
	
	# Ends subcontent section, with optional id, and load_more options
	private function end_content_section($options){
				
		if(isset($options['load_more'])){
			$html .= <<<HTML

					<p class="load-more"><a href="{$options['load_more_link']}" title="{$this->lang->text('load_more')} {$options['load_more']}...">{$this->lang->text('load_more')}</a></p>
HTML;
		}
		$html .= <<<HTML

				</section><!-- END {$options['id']} -->
HTML;
		return $html;
	}
	
	
	
	# Extra content pieces (filters, slider controls, etc)
	private function get_extra($id, $options = null) {
		
		$extras = array(
			'latest_filters' => <<<HTML
<div class="secondary filters">
						<a href="{$_SERVER['REQUEST_URI']}#all" title="{$this->lang->text('filter_all_title')}" class="current">{$this->lang->text('all')}</a>
						<a href="{$_SERVER['REQUEST_URI']}#people" title="{$this->lang->text('filter_people_title')}">{$this->lang->text('people')}</a> 
						<a href="{$_SERVER['REQUEST_URI']}#projects" title="{$this->lang->text('filter_projects_title')}">{$this->lang->text('projects')}</a> 
						<a href="{$_SERVER['REQUEST_URI']}#articles" title="{$this->lang->text('filter_articles_title')}">{$this->lang->text('articles')}</a>
					</div><!-- END SECONDARY -->
HTML
			,'user_latest_filters' => <<<HTML
<div class="secondary filters">
						<a href="{$_SERVER['REQUEST_URI']}#all" title="{$this->lang->text('all_latest_activity')}" class="current">{$this->lang->text('all')}</a> 
						<a href="{$_SERVER['REQUEST_URI']}#projects" title="{$this->lang->text('latest_projects')}">{$this->lang->text('projects')}</a> 
						<a href="{$_SERVER['REQUEST_URI']}#articles" title="{$this->lang->text('latest_articles')}">{$this->lang->text('articles')}</a>
					</div><!-- END SECONDARY -->
HTML
			,'course_latest_filters' => <<<HTML
<div class="secondary filters">
						<a href="{$_SERVER['REQUEST_URI']}#all" title="{$this->lang->text('filter_all_title')}" class="current">{$this->lang->text('all')}</a>
						<a href="{$_SERVER['REQUEST_URI']}#projects" title="{$this->lang->text('filter_projects_title')}">{$this->lang->text('projects')}</a> 
						<a href="{$_SERVER['REQUEST_URI']}#articles" title="{$this->lang->text('filter_articles_title')}">{$this->lang->text('articles')}</a>
					</div><!-- END SECONDARY -->
HTML
			,'slider_controls' => <<<HTML
<div class="slider-controls"><a href="{$_SERVER['REQUEST_URI']}" title="Featured 1" class="current">1</a> <a href="{$_SERVER['REQUEST_URI']}" title="Featured 2">2</a> <a href="{$_SERVER['REQUEST_URI']}" title="Featured 3">3</a> <a href="{$_SERVER['REQUEST_URI']}" title="Featured 4">4</a> <a href="{$_SERVER['REQUEST_URI']}" title="Featured 5">5</a></div>
HTML
		);
		
		return $extras[$id];
	}
	
	
	
	# Extra content pieces (filters, slider controls, etc)
	private function sorters($sorters, $active, $base_link) {
		$string = <<<HTML

					<div class="secondary">
HTML;
		foreach ($sorters as $url => $title) {
			$title = ucfirst($title);
			if ($url == $active)
				$class = ' class="current"';
			else
				$class = '';
			
			$string .= <<<HTML

						<a href="{$base_link}$url" title="Sort | $title"$class>$title</a> 
HTML;
		}
		$string .= <<<HTML

					</div><!-- END SECONDARY -->
HTML;
		return $string;
	}
}