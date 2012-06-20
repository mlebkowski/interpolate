<?php namespace Nassau\Interpolate\ContextEscaper;

use Nassau\Interpolate\ContextEscaperInterface as Base;

class Html implements Base {
	public function escape($value) {
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
}
