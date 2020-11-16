<?php

namespace PorthTermau;

/**
 * Wrapper class for the PorthTermau API.
 *
 * Usage:
 * include('src/PorthTermau.php');
 * $api = new PorthTermau\PorthTermauWrapper(
 *   ['key' => 'secret key', 'referer' => 'http://llennatur.cymru']
 * );
 * echo $api->searchTerm('cy', 'celyn');
 *
 */
class PorthTermauWrapper {

  /**
   * PorthTermau API endpoint.
   */
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
   *
   * @param array $options
   *   An array of options keyed thus:
   *   [
   *     'key' => secret api key,
   *     'referer' => the referer url,
   *   ]
   */
  public function __construct($options) {
    if (isset($options['key'])) {
      $this->setApiKey($options['key']);
    }
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
   */
  public function searchTerm($language, $term, $results = 1) {
    $request = $this->searchTermRequest($language, $term);
    // process the json here to return only the specified number of results.
  }

  /**
   * Perform a request for a search term.
   *
   * @param string $language
   *   The two letter language code of the search term.
   * @param string $term
   *   The search term.
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
   */
  public function listTerms($language, $letter = null) {
    return $this->request([
      'sln' => $language,
      'letter' => $letter,
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
  public function getReferrer() {
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
