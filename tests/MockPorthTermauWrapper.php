<?php

namespace PorthTermau;

/**
 * Test class based on PorthTermauWrapper.
 *
 * Overrides methods that are tightly bound the to API in order to run unit
 * tests.
 */
class MockPorthTermauWrapper extends PorthTermauWrapper {

  /**
   * {@inheritdoc}
   */
  public function __construct($options) {
    // Override constructor so we don't need to set an API key.
  }

  /**
   * {@inheritdoc}
   */
  protected function searchTermRequest($language, $term) {
    // Instead of performing a real API request, return a dummy response.
    return '{"search":"Vulpes vulpes","level1Count":0,"level2Count":0,"l3Search":"","l4Search":"Vulpes, vulpes","entries":[{"headword":"Vulpes vulpes","src":"\u003cdiv property=\"PT_DictionaryEntry\" lang=\"lat\" xml:lang=\"lat\"\u003e\u003cdiv property=\"PT_Heading\"\u003e\u003cspan property=\"PT_term\"\u003eVulpes vulpes\u003c/span\u003e\u003c/div\u003e\u003cdiv property=\"PT_Concept\"\u003e\u003cdiv property=\"PT_Preferred\"\u003e\u003cdiv property=\"PT_entry\"\u003e\u003cspan property=\"PT_term\"\u003eVulpes vulpes\u003c/span\u003e\u003c/div\u003e\u003c/div\u003e\u003cdiv property=\"PT_LanguageSection\" xml:lang=\"cy\" lang=\"cy\"\u003e\u003cdiv property=\"PT_Preferred\"\u003e\u003cdiv property=\"PT_entry\"\u003e\u003cspan property=\"PT_term\"\u003ecadno\u003c/span\u003e\u003cspan property=\"PT_ptOfSpeech\"\u003eeg\u003c/span\u003e\u003cspan property=\"PT_plural\"\u003ecadnoaid\u003c/span\u003e\u003c/div\u003e\u003c/div\u003e\u003c/div\u003e\u003cdiv property=\"PT_LanguageSection\" xml:lang=\"en\" lang=\"en\"\u003e\u003cdiv property=\"PT_Preferred\"\u003e\u003cdiv property=\"PT_entry\"\u003e\u003cspan property=\"PT_term\"\u003efox\u003c/span\u003e\u003c/div\u003e\u003c/div\u003e\u003c/div\u003e\u003cdiv property=\"PT_Definitions\"\u003e\u003cspan xml:lang=\"cy\" lang=\"cy\"\u003e\u003cdiv\u003e\u003ca href=\"https://cy.wikipedia.org/wiki/cadno\"\u003ecadno ar Wicipedia\u003c/a\u003e\u003c/div\u003e\u003cdiv\u003e\u003ca href=\"http://commons.wikimedia.org/wiki/File:Captive_red_foxes.JPG\" title=\"GDallimore (Own work) [CC-BY-SA-3.0 (http://creativecommons.org/licenses/by-sa/3.0/legalcode) or GFDL (http://www.gnu.org/licenses/fdl.txt)]\"\u003e\u003cimg width=\"512\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Captive_red_foxes.JPG/512px-Captive_red_foxes.JPG\" alt=\"Captive%20red%20foxes.JPG\" /\u003e\u003c/a\u003e\u003c/div\u003e\u003c/span\u003e\u003c/div\u003e\u003c/div\u003e\u003cdiv property=\"PT_Dictionaries\"\u003e\u003cdiv property=\"PT_Dictionary\" id=\"13006_24895_5592\"\u003e\u003cspan lang=\"cy\" xml:lang=\"cy\"\u003eCreaduriaid Asgwrn-Cefn. Cymdeithas Edward Llwyd 1994\u003c/span\u003e\u003c/div\u003e\u003c/div\u003e\u003c/div\u003e","language":"lat","type":"1","ranking":"1000","isPublished":true}],"elapsed":"","success":true,"error":""}';
  }
}
