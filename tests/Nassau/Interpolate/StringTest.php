<?php namespace Nassau\Interpolate;

class StringTest extends TestCase {

	/**
	 * @dataProvider parameterNames
	 */
	public function testFindingParameterNames($name) {
		$str = new String(":$name");
		$value = $name . 'Value';
		$result = $str->interpolate(array ($name => $value));
		$this->assertEquals($value, $result);
	}
	
	/**
	 * @dataProvider badParameterNames
	 */
	public function testFindingInvalidParameterNames($name) {
		$pattern = ":$name";
		$str = new String($pattern);
		$result = $str->interpolate(array ($name => ""));
		$this->assertEquals($pattern, $result);
		
	}
	
	public function testDefaultContextEscapers() {
		$s = new String();
		$this->assertNull($s->getContextEscaper(String::CONTEXT_DEFAULT));
		$this->assertInstanceOf('\\Nassau\\Interpolate\\ContextEscaper\\Html', $s->getContextEscaper(String::CONTEXT_HTML));
		$this->assertInstanceOf('\\Nassau\\Interpolate\\ContextEscaper\\Sql', $s->getContextEscaper(String::CONTEXT_SQL));
	}
	public function testSettingContextEscaper() {
		$s = new String(null, String::CONTEXT_HTML);
		$s -> setEscaper(null);
		$this->assertNull($s->getEscaper());
	}
	
	public function parameterNames() {
		return array (
			'simple' => array ('simple'),
			'numeric' => array ('0123'),
			'long'	=> array (str_repeat('a', 1000)),
			'alphanum' => array ('simple123'),
			'alphanum_under' => array ('simple_123'),
		);
	}
	public function badParameterNames() {
		return array (
			array ('not-a-name'),
			array ('#invalid'),
			array (":startswithcolon"),
		);
	}
}
