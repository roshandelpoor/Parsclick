<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit4d0ed314ef753fc5ee370e97f5587cd3 {

	private static $loader;

	public static function loadClassLoader($class)
	{
		if('Composer\Autoload\ClassLoader' === $class) {
			require __DIR__ . '/ClassLoader.php';
		}
	}

	public static function getLoader()
	{
		if(NULL !== self::$loader) {
			return self::$loader;
		}

		spl_autoload_register(array(
			'ComposerAutoloaderInit4d0ed314ef753fc5ee370e97f5587cd3',
			'loadClassLoader'
		), TRUE, TRUE);
		self::$loader = $loader = new \Composer\Autoload\ClassLoader();
		spl_autoload_unregister(array('ComposerAutoloaderInit4d0ed314ef753fc5ee370e97f5587cd3', 'loadClassLoader'));

		$map = require __DIR__ . '/autoload_namespaces.php';
		foreach($map as $namespace => $path) {
			$loader->set($namespace, $path);
		}

		$map = require __DIR__ . '/autoload_psr4.php';
		foreach($map as $namespace => $path) {
			$loader->setPsr4($namespace, $path);
		}

		$classMap = require __DIR__ . '/autoload_classmap.php';
		if($classMap) {
			$loader->addClassMap($classMap);
		}

		$loader->register(TRUE);

		return $loader;
	}
}
