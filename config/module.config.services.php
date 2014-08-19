<?php

// set file namespace
namespace PequenoSpotifyModule;

// return service manager configuration
return array(
    'aliases' => array(
        'pequeno.services.spotify' => 'Pequeno\Services\Spotify',
    ),
    'factories' => array(
        'Pequeno\Services\Spotify' => function ($sm) {
            // return new Spotify service instance
            return new Spotify();
        },
    ),
);
