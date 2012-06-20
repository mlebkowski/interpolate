<?php namespace Nassau\Interpolate;

class String {

	const CONTEXT_HTML = 'html';
	const CONTEXT_SQL = 'sql';
	const CONTEXT_DEFAULT = '';
	
	const REGEX_PARAM = '[a-zA-Z0-9_]+';

	protected $pattern;
	protected $re_param = ':(?<name>(?&param))\b';
	protected $context = self::CONTEXT_DEFAULT;
	
	protected $_ce = array ();
	
	public function __construct($pattern = "", $context = self::CONTEXT_DEFAULT) {
		return $this->setPattern($pattern)->setContext($context);
	}
	
	public static function create($pattern) {
		return new self($pattern);
	}

	public function setContext($context) {
		$this->context = $context;
		return $this;
	}
	public function getContext() {
		return $this->context;
	}

	public function getPattern() {
		return $this->pattern;
	}
	
	public function setPattern($pattern) {
		$this->pattern = $pattern;
		return $this;
	}
	
	public function interpolate(array $params, $context = self::CONTEXT_DEFAULT) {
		if (func_num_args() > 1) {
			$contextEscaper = $this->getContextEscaper($context);
		} else {
			$contextEscaper = $this->getEscaper();
		}
		
		$re = '/' . $this->re_param . '(?(DEFINE)(?<param>' . self::REGEX_PARAM . '))/x';

		return preg_replace_callback($re, function ($match) use ($contextEscaper, $params) {
			$name = $match['name'];
			if (false !== isset($params[$name])) {
				$value = $params[$name];
				
				if (null !== $contextEscaper) {
					$value = $contextEscaper->escape($value);
				}
			} else {
				$value = $match[0];
			}
			
			return $value;
		}, $this->pattern);
	}
	/** 
	 * Get the default contextEscaper, or user specified if any
	 */
	public function getContextEscaper($context = self::CONTEXT_DEFAULT) {
		if (false === array_key_exists($context, $this->_ce)) {

			switch ($context):
			case self::CONTEXT_HTML:
				$this->setContextEscaper($context, new ContextEscaper\Html());
				break;
			case self::CONTEXT_SQL: 
				$this->setContextEscaper($context, new ContextEscaper\Sql());
				break;
			case self::CONTEXT_DEFAULT:
			default:
				$this->setContextEscaper($context, null);
				break;
			endswitch;
			
		}
		
		return $this->_ce[$context];
	}
	
	public function setEscaper(ContextEscaperInterface $contextEscaper = null) {
		$this->setContextEscaper($this->getContext(), $contextEscaper);
		return $this;
	}
	public function getEscaper() {
		return $this->getContextEscaper($this->getContext());
	}
	public function setContextEscaper($context, ContextEscaperInterface $contextEscaper = null) {
		return $this->_ce[$context] = $contextEscaper;
	}
}
