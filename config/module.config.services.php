<?php

// set file namespace
namespace PequenoSpotifyModule;

// return service manager configuration
return array(
    'aliases' => array(
        'Pequeno\Service\SpotifyService' => 'pequeno.services.spotify',
    ),
    'factories' => array(
        'pequeno.services.spotify' => function($sm) {
            // return new SpotifyService instance
            return new \PequenoSpotifyModule\Service\SpotifyService();
        },
    ),
);
