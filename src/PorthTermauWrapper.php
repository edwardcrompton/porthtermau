<?php

namespace PorthTermau;

require __DIR__ . '/../vendor/autoload.php';
use PHPHtmlParser\Dom;

/**
 * Wrapper class for the PorthTermau API.
 *
 * Usage:
 * include('src/PorthTermauWrapper.php');
 * $api = new PorthTermau\PorthTermauWrapper(
 *   ['key' => 'secret key', 'referer' => 'http://llennatur.cymru']
 * );
 * $api->searchForTerm('cy', 'celyn');
 *
 */
class PorthTermauWrapper {

  /**
   * PorthTermau API endpoint.
   */
  const TERM_ENDPOINT = 'https://api.termau.org/Search/Default.ashx';

  /**
   * HTML Dom property for the term name.
   */
  const TERM_PROPERTY = 'PT_term';

  /**
   * The name of the environment variable holding the api key.
   */
  const API_KEY_ENV_VAR_NAME = 'PORTHTERMAU_API_KEY';
  
  /**
   * An array of headers to send with a request.
   */
  protected $headers;

  /**
   * The api key to use for requests.
   */
  protected $apiKey;

  /**
   *
   * @param array $options
   *   An array of options keyed thus:
   *   [
   *     'key' => secret api key,
   *     'referer' => the referer url,
   *   ]
   */
  public function __construct($options) {
    $envApiKey = isset($options['key']) ? $options['key'] : getenv(static::API_KEY_ENV_VAR_NAME);
    
    if (!$envApiKey) {
      throw new \Exception('An API key must be supplied as a constructor parameter or an environment variable.');
    }
    $this->setApiKey($envApiKey);
    
    if (isset($options['referer'])) {
      $this->setReferer($options['referer']);
    }
  }

  /**
   * Search for a term in a particular language.
   *
   * @param string $language
   *   The two letter language code of the search term.
   * @param string $term
   *   The search term.
   * @param int $results
   *   The number of results to return.
   *
   * @return array
   *   An array of result objects.
   */
  public function searchForTerm($language, $term, $results = 1) {
    $response = $this->searchTermRequest($language, $term);
    $responseObject = json_decode($response);
    return array_slice($responseObject->entries, 0, $results);
  }

  /**
   * Translate term.
   *
   * @param string $language
   *   The two letter language code of the language to translate to.
   * @param string $term
   *   The search term in any language.
   */
  public function translateTerm($language, $term) {
    $response = $this->searchForTerm($language, $term);
    return $this->parseResponse($language, static::TERM_PROPERTY, $response);
  }

  /**
   * Parse the response to return a given property in a given language.
   *
   * @param type $language
   *   Two letter language code to look for a value in.
   * @param type $property
   *   The value to return.
   * @param type $response
   *   The search response.
   *
   * @return string
   *   The parsed response string.
   */
  public function parseResponse($language, $property, $response) {
    $dom = new Dom;
    $dom->loadStr($response[0]->src);

    $cy = $dom->find("[property=PT_LanguageSection][lang=${language}] [property=${property}]")[0];
    return $cy->text;
  }

  /**
   * Perform a request for a search term.
   *
   * @param string $language
   *   The two letter language code of the search term.
   * @param string $term
   *   The search term.
   *
   * @return string
   *   A json response.
   */
  protected function searchTermRequest($language, $term) {
    return $this->request([
      'dln' => $language,
      'string' => $term,
    ]);
  }

  /**
   * List multiple terms in a particular language.
   *
   * @param string $language
   *   The two letter language code in which to list terms.
   * @param string $letter
   *   Returns terms beginning with this letter of the alphabet. If null
   *   returns all terms.
   *
   * @return string
   *   A json response.
   */
  public function listTerms($language, $letter = null) {
    $parameters = ['sln' => $language];

    if ($letter) {
      $parameters['letter'] = $letter;
    }

    return $this->request($parameters);
  }

  /**
   * Sets the referer header for requests.
   *
   * E.g. http://llennatur.cymru
   */
  public function setReferer($referer) {
    $this->headers['Referer'] = $referer;
  }

  /**
   * Get the current referer value.
   */
  public function getReferer() {
    return $this->headers['Referer'];
  }

  /**
   * Set the request api key.
   *
   * @param type $key
   *   The private API key.
   */
  public function setApiKey($key) {
    $this->apiKey = $key;
  }

  /**
   * Build and send a request.
   *
   * @param array $parameters
   *   An array of query parameters to send with the request.
   */
  protected function request($parameters) {
    $parameters['apikey'] = $this->apiKey;
    $url = static::TERM_ENDPOINT . '?' . http_build_query($parameters);
    $curlHandle = curl_init($url);

    foreach($this->headers as $name => $value) {
      $headers[] = "${name}: ${value}";
    }

    curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curlHandle);
    if (!$response) {
      throw new Exception('Failed to connect to URL %s', [$url]);
    }
    curl_close($curlHandle);

    return $response;
  }

}
