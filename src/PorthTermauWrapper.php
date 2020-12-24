<?php

namespace PorthTermau;

require __DIR__ . '/../vendor/autoload.php';
use PHPHtmlParser\Dom;

/**
 * Wrapper class for the PorthTermau API.
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
   * Language for non-translated properties of the API response.
   */
  const DEFAULT_LANGUAGE = 'cy';

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
   * Make a request to the API for a search term.
   *
   * @param string $term
   *   The term to search for.
   *
   * @return $this
   *   The api wrapper object, so that this method can be chained.
   */
  public function lookup($term) {
    $this->response = $this->searchForTerm('lat', $term);
    return $this;
  }

  /**
   * Translate term.
   *
   * @param string $language
   *   The two letter language code of the language to translate to.
   *
   * @return string
   *   The translated term.
   */
  public function translate($language) {
    if (!isset($this->response)) {
      throw new Exception('Attempting to translate a term without doing a lookup first.');
    }
    return $this->parseResponse($language, static::TERM_PROPERTY, $this->response);
  }

  /**
   * Get the title of the term in a given language.
   * 
   * @param string $language
   *   The two letter language code of the language to fetch the title in.
   * 
   * @return string
   *   The term title.
   */
  public function getTitle($language) {
    return $this->translate($language);
  }

  /**
   * Get the URL of a related image.
   *
   * @return string
   *   The image URL.
   */
  public function getImageThumb() {
    $dom = new Dom;
    $dom->loadStr($this->response[0]->src);

    $element = $dom->find("[property=PT_Definitions] [lang=" . static::DEFAULT_LANGUAGE . "] img")[0];
    return $element->src;
  }

  /**
   * Get the URL of the related article on Wikipedia.
   *
   * This is currently only available in Welsh.
   *
   * @return string
   *   The article URL.
   */
  public function getUrl() {
    $dom = new Dom;
    $dom->loadStr($this->response[0]->src);

    $element = $dom->find("[property=PT_Definitions] [lang=" . static::DEFAULT_LANGUAGE . "] a")[0];
    return $element->href;
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

    $element = $dom->find("[property=PT_LanguageSection][lang=${language}] [property=${property}]")[0];
    return $element->text;
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
