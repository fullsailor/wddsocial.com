<?php

namespace WDDSocial;

/*
* 
* @author Anthony Colangelo (me@acolangelo.com)
*/

class VerificationEmail implements \Framework5\IView {

	public function render($options = null) {
		return <<<HTML

			<h1><a href="http://www.dev.wddsocial.com/" title="WDD Social | Connecting the Full Sail University web community."><img alt="WDD Social | Connecting the Full Sail University web community." src="http://www.wddsocial.com/images/emails/social.logo.png" /></a></h1>
			<h2>Feedback Message</h2>
			<p>From: {$options['name']} (<a href="mailto:{$options['email']}">{$options['email']}</a>)</p>
			<p>{$options['email']}</p>
			<p class="signOff">WDD Social Mailer</p>
HTML;
	}
}