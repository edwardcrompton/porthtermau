## PorthTermau API wrapper

[![Build Status](https://travis-ci.org/edwardcrompton/porthtermau.svg?branch=main)](https://travis-ci.org/edwardcrompton/porthtermau)

This is a PHP wrapper for the PorthTermau API.

https://www.bangor.ac.uk/cymorthcymraeg/porth_termau.php.cy

You will require an API key issued by Bangor University to use the API.

This is currently a work in progress and more documentation will follow.

To install with composer:

`composer require edwardcrompton/porthtermau:dev-main`

To clone from git and install:

`git clone git@github.com:edwardcrompton/porthtermau.git`

`cd porthtermau`

`composer install`

To run phpunit tests:

`./vendor/bin/phpunit tests`

### Usage

```
include('src/PorthTermauWrapper.php');
$api = new PorthTermau\PorthTermauWrapper(
  ['key' => 'secret key', 'referer' => 'http://llennatur.cymru']
);
// Look up a term
$term = $api->lookup('Vulpes vulpes');

// Translate the term to Cymraeg
$cyTerm = $term->translate('cy');

// Translate the term to English
$enTerm = $term->translate('en');

// Get the Url of the term in cy.wikipedia.org.
$url = $term->getUrl();

// Get an thumbnail image URL for the term
$img = $term->getImageThumb();
```
