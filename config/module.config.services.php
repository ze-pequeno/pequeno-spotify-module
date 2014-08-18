<?php

// set file namespace
namespace PequenoSpotifyModule;

// return service manager configuration
return array(
    'aliases' => array(
        'pequeno.services.spotify' => 'Pequeno\Service\SpotifyService',
    ),
    'factories' => array(
        'Pequeno\Service\SpotifyService' => function ($sm) {
            // return new SpotifyService instance
            return new \PequenoSpotifyModule\Service\SpotifyService();
        },
    ),
);
