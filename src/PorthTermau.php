<?php

namespace PorthTermau;

class PorthTermauWrapper {

  const TERM_ENDPOINT = 'https://api.termau.org/Search/Default.ashx';

  /**
   * An array of headers to send with a request.
   */
  protected array $headers;

  /**
   * The api key to use for requests.
   */
  protected string $apiKey;

  /**
   * Search for a term in a particular language.
   * 
   * @param string $language
   *   The two letter language code of the search term.
   * @param string $term
   *   The search term.
   */
  public function searchTerm($language, $term) {

  }

  /**
   * List multiple terms in a particular language.
   * 
   * @param string $language
   *   The two letter language code in which to list terms.
   * @param string $letter
   *   Returns terms beginning with this letter of the alphabet. If null
   *   returns all terms.
   */
  public function listTerms($language, $letter = null) {

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
  public function getReferrer() {
    return $this->headers['Referer'];
  }

  /**
   * Set the request api key.
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
    $url = static::TERM_ENDPOINT . '?' . $this->buildParameters($parameters);
    $curlHandle = curl_init($url);

    foreach($this->headers as $name => $value) {
      $headers[] = '{$name}: {$value}';
    }
    
    curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);

    // Add curl_exec and more crul_setopt if necessary here.
  }

  /**
   * Build a URL parameter string from an array of parameters.
   */
  protected function buildParameters($parameters) {
    $queryArray = [];
    foreach ($parameters as $name => $value) {
      $queryArray[] = '{$name}={$value}';
    }
    $queryString = implode("&", $queryArray);
  }

}
