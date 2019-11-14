<?php
/**
 * Автозагрузчик 
 *
 * @author Alliline <inline-webb@yandex.ru>
 */

define( 'ROOT_DIR', __DIR__ );
define( 'EXPORT_BASE', true );

use ExportBase\Engine;

spl_autoload_register(
	function( $class ) {
		$prefix = 'ExportBase\\';
		$baseDir = __DIR__ . '/vendor/';
		$len = strlen($prefix);
		if( strncmp($prefix, $class, $len) !== 0 ) {
			return;  
		}
		$relativeClass = substr($class, $len);
		$file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
		if( file_exists( $file ) ) {
			include_once $file;
		}
	}
);

Engine::load();
@session_start();