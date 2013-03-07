# Zend Framework 2 Module for Spotify Web API
====================

[![Build Status](https://travis-ci.org/ze-pequeno/PequenoSpotifyModule.png?branch=master)](https://travis-ci.org/ze-pequeno/PequenoSpotifyModule)

PequenoSpotifyModule integrates Spotify Web API with Zend Framework 2 quickly and easily.

  - Search service support
  - Lookup service support

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
php composer.phar require ze-pequeno/pequeno-spotify-module
# (When asked for a version, type `0.*`)
```

Then add `PequenoSpotifyModule` to your `config/application.config.php`.

Installation without composer is not officially supported and requires you to manually install all dependencies
that are listed in `composer.json`

## Registered Service names

 * `pequeno.services.spotify`: a `PequenoSpotifyModule\Service\SpotifyService` instance
 * `Pequeno\Service\SpotifyService`: an alias of `pequeno.services.spotify`

#### Service Locator
To access the SpotifyService, use the main service locator:

```php
// for example, in a controller:
$spotify = $this->getServiceLocator()->get('pequeno.services.spotify');
$spotify = $this->getServiceLocator()->get('Pequeno\Service\SpotifyService');
```
