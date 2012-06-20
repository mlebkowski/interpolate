<?php namespace Nassau\Interpolate\ContextEscaper;

use Nassau\Interpolate\TestCase;

class HtmlTest extends TestCase {

	/**
	 * @dataProvider quotesProvider
	 */
	public function testEscapeQuotes($value, $escaped) {
		$escaper = new Html();
		$this->assertEquals($escaped, $escaper->escape($value));
	}
	
	/**
	 * @dataProvider entitiesProvider
	 */
	public function testEscapeEntities($value, $escaped) {
		$escaper = new Html();
		$this->assertEquals($escaped, $escaper->escape($value));
	}
	
	public function testPlainSentences() {
		$escaper = new Html();
		$value = 'Ullutpat incing enissim feuisi lorer adipis ipsum quatuerit incinis. Incinci ip nostra laoreet feuismodolor faucibus felis adipis cum; sequat volore euissim sandigna aciliquis nostra. Quatio volorerci magnis sismolore minit am eraestie in iniam; henis ipsustrud lobortis dipissit lor lan. Netus rutrum facidunt, aliquisi dignis, rilit nostrud, euisl deliquatue niat ercincil lobore. Viverra lobor veliquiisi. Senectus cipsusto rilisit, auguero maecenas, tatue la, nostie feugait essisis sequis iuscing. Henisi essi verci at ipsustie. Psusto henim at volobore potenti nascetur modo. ';
		$this->assertEquals($value, $escaper->escape($value));
	}
	
	public function quotesProvider() {
		return array (
			array ('"', '&quot;'),
			array ("'", '&#039;'),
			array ('&quot;', '&amp;quot;'),
		);
	}
	
	public function entitiesProvider() {
		return array (
			array ('&', '&amp;'),
			array ('<', '&lt;'),
			array ('>', '&gt;'),
		); 
	}
}
