<?php

// set file namespace
namespace PequenoSpotifyModule;

// return configuration
return array(
	// include controllers configuration
	'controllers' => include 'module.config.controllers.php',
	// include router configuration
	'router' => include 'module.config.routes.php',
	// include service manager configuration
	'service_manager' => include 'module.config.services.php',
	// include view manager configuration
	'view_manager' => include 'module.config.viewmanager.php',
);
