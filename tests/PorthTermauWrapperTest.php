<?php

namespace PorthTermau;

use PHPUnit\Framework\TestCase;

/**
 * Test class for PorthTermauWrapper.
 */
class PorthTermauWrapperTest extends TestCase {

  /**
   * Test the TranslateTerm method.
   */
  public function testTranslateTerm() {
    $api = new MockPorthTermauWrapper(['referer' => 'http://llennatur.cymru']);

    $cyTerm = $api->translateTerm('cy', 'Vulpes vulpes');
    $this->assertEquals('cadno', $cyTerm);

    $enTerm = $api->translateTerm('en', 'Vulpes vulpes');
    $this->assertEquals('fox', $enTerm);
  }

}
