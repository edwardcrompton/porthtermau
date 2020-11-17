<?php

namespace PorthTermau;

use PHPUnit\Framework\TestCase;

/**
 * Test class for PorthTermauWrapper.
 */
class PorthTermauWrapperTest extends TestCase {

  public function testTranslateTerm() {
    $api = new PorthTermauWrapper(['referer' => 'http://llennatur.cymru']);
  }
}
