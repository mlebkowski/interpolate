<?php namespace Nassau\Interpolate\ContextEscaper;

use Nassau\Interpolate\ContextEscaperInterface as Base;

class Sql implements Base {
	protected $pdo;
	
	public function __construct(\PDO $PDO = null) {
		$this->pdo = $PDO;
	}
	public function escape($value) {
		if ($this->pdo) return $this->pdo->quote($value);
		
		$pattern = is_numeric($value) ? '%s' : "'%s'";
		return sprintf($pattern, mysql_escape_string($value));
	}
}
