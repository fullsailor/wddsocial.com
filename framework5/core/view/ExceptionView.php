<?php

namespace Framework5;

class ExceptionView implements IView {
	
	public function render($e = null) {
		
		$html = <<<HTML
		
		<h2>You dun goofed</h2>
		<p>
			Exception caught with message: <span style="font-weight: bold">{$e->getMessage()}</span><br/>
			thrown in <span style="font-weight: bold">{$e->getFile()}</span>
			on line <span style="font-weight: bold">{$e->getLine()}</span>
		</p>
		
		<h2>We backtraced it</h2>
HTML;
		
		$trace_array = $e->getTrace();
		foreach ($trace_array as $trace) {
		$html .= <<<HTML
		<table>
			<tr>
				<td>file</td>
				<td>{$trace['file']}</td>
			</tr>
			<tr>	
				<td>line</td>
				<td>{$trace['line']}</td>
			</tr>
			<tr>	
				<td>method</td>
				<td>{$trace['function']}</td>
			</tr>
			<tr>
				<td>Namespace</td>
				<td>{$trace['class']}</td>
			</tr>

HTML;
			if ($trace['args']) {
				foreach ($trace['args'] as $arg) {
					if (!is_string($arg)) $arg = gettype($arg);
					$html .= <<<HTML
			<tr>
				<td>arg</td>
				<td>$arg</td>
			</tr>

HTML;
					
				}
			}
		
		$html .= <<<HTML
		</table>

HTML;
			
		}
		return $html;
	}
}
