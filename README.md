Zend Framework 2 Module for Spotify Web API
====================

[![Build Status](https://travis-ci.org/ze-pequeno/pequeno-spotify-module.png?branch=master)](https://travis-ci.org/ze-pequeno/pequeno-spotify-module) [![Coverage Status](https://coveralls.io/repos/ze-pequeno/pequeno-spotify-module/badge.png?branch=master)](https://coveralls.io/r/ze-pequeno/pequeno-spotify-module?branch=master)

PequenoSpotifyModule integrates Spotify Web API with Zend Framework 2 quickly and easily.

  - Search service support
  - Lookup service support

## Release Information

Pequeno Spotify Module 1.0.6dev

This is the sixth maintenance release for the version 1.0 series.

03 February 2014

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
php composer.phar require ze-pequeno/pequeno-spotify-module
# (When asked for a version, type `1.*`)
```

Then add `PequenoSpotifyModule` to your `config/application.config.php`.

Installation without composer is not officially supported and requires you to manually install all dependencies
that are listed in `composer.json`

## Registered Service Names

 * `pequeno.services.spotify`: a `PequenoSpotifyModule\Service\SpotifyService` instance
 * `Pequeno\Service\SpotifyService`: an alias of `pequeno.services.spotify`

#### Service Locator
To access the SpotifyService, use the main service locator:

```php
// for example, in a controller:
$spotify = $this->getServiceLocator()->get('pequeno.services.spotify');
$spotify = $this->getServiceLocator()->get('Pequeno\Service\SpotifyService');
```
