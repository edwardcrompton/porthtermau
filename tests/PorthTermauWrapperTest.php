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

  /**
   * Test the TermImageThumb method.
   */
  public function testTermImageThumb() {
    $api = new MockPorthTermauWrapper(['referer' => 'http://llennatur.cymru']);

    $cyThumb = $api->termImageThumb('cy', 'Vulpes vulpes');
    $this->assertEquals('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Captive_red_foxes.JPG/512px-Captive_red_foxes.JPG', $cyThumb);
  }

}
