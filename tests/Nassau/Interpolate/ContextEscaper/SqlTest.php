<?php namespace Nassau\Interpolate\ContextEscaper;

use Nassau\Interpolate\TestCase;

class SqlTest extends TestCase {

	/**
	 * @dataProvider quotesProvider
	 */
	public function testEscapeQuotes($value, $escaped) {
		$escaper = new Sql();
		$this->assertEquals("'" . $escaped . "'", $escaper->escape($value));
	}
	
	/**
	 * @dataProvider numericProvider
	 */
	public function testEscapeNumeric($value, $escaped) {
		$escaper = new Sql();
		$this->assertEquals($escaped, $escaper->escape($value));
	}
	
	public function testPlainSentences() {
		$escaper = new Sql();
		$value = 'Ullutpat incing enissim feuisi lorer adipis ipsum quatuerit incinis. Incinci ip nostra laoreet feuismodolor faucibus felis adipis cum; sequat volore euissim sandigna aciliquis nostra. Quatio volorerci magnis sismolore minit am eraestie in iniam; henis ipsustrud lobortis dipissit lor lan. Netus rutrum facidunt, aliquisi dignis, rilit nostrud, euisl deliquatue niat ercincil lobore. Viverra lobor veliquiisi. Senectus cipsusto rilisit, auguero maecenas, tatue la, nostie feugait essisis sequis iuscing. Henisi essi verci at ipsustie. Psusto henim at volobore potenti nascetur modo. ';
		$this->assertEquals("'" . $value . "'", $escaper->escape($value));
	}
	
	public function quotesProvider() {
		return array (
			array ('"', '\\"'),
			array ("'", "\\'"), // slash, apos
		);
	}
	
	public function numericProvider() {
		return array (
			array ('1', '1'),
			array ('1e10', '1e10'),
			array ('1.40', '1.40'),
			array ('-1', '-1'),
			array ('050', '050'),
		); 
	}
}
