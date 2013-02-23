<?php

/**
 * Classmap autoload function
 * @access public
 * @param string $class Class name to load
 * @return mixed
 */
return function ($class) {

	// setup classmap container
    static $classMap;

	// check if classmap container is not defined
	if (!$classMap) {

		// include classmap
		$classMap = include __DIR__ .'/autoload_classmap.php';
	}

	// check if class exist on classmap
	if (isset($classMap[$class])) {

		// return class inclusion from class map
		return include $classMap[$class];
	}

	// class not found on classmap, so return false
	return false;
};
