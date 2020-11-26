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
  public function testTranslate() {
    $api = new MockPorthTermauWrapper(['referer' => 'http://llennatur.cymru']);

    $cyTerm = $api->lookup('Vulpes vulpes')->translate('cy');
    $this->assertEquals('cadno', $cyTerm);

    $enTerm = $api->lookup('Vulpes vulpes')->translate('en');
    $this->assertEquals('fox', $enTerm);
  }

  /**
   * Test the GetImageThumb method.
   */
  public function testGetImageThumb() {
    $api = new MockPorthTermauWrapper(['referer' => 'http://llennatur.cymru']);

    $cyThumb = $api->lookup('Vulpes vulpes')->getImageThumb();
    $this->assertEquals('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Captive_red_foxes.JPG/512px-Captive_red_foxes.JPG', $cyThumb);
  }

  /**
   * Test the GetUrl method.
   */
  public function testGetUrl() {
    $api = new MockPorthTermauWrapper(['referer' => 'http://llennatur.cymru']);

    $cyUrl = $api->lookup('Vulpes vulpes')->getUrl();
    $this->assertEquals('https://cy.wikipedia.org/wiki/cadno', $cyUrl);
  }


}
