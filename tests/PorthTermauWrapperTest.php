<?php

/**
 * @file
 *  Contains class TestTranslateTerm.
 */

namespace PorthTermau;

use PHPUnit\Framework\TestCase;

/**
 * Class TestTranslateTerm
 */
class PorthTermauWrapperTest extends TestCase {

  public function testTranslateTerm() {
    $api = new PorthTermauWrapper(['key' => '', 'referer' => 'http://llennatur.cymru']);
  }
}
