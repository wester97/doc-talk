<?php

class BaseTest extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'Doc_Talk') );
	}
	
	function test_get_instance() {
		$this->assertTrue( doc_talk() instanceof Doc_Talk );
	}
}
