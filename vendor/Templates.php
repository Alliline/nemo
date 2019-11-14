<?php
/**
 * Шаблонизатор
 *
 * @author Alliline <inline-webb@yandex.ru>
 */

namespace ExportBase;

use ExportBase\Engine;

class Templates {

	public $result = array();
	protected $dir = '';
	protected $tpl = null;
	protected $tpl_copy = null;
	protected $data = array();

	public function __construct() {
		$this->dir = ROOT_DIR . DIRECTORY_SEPARATOR . Engine::$config['theme_folder'] . DIRECTORY_SEPARATOR;
	}

	/**
	 * Загрузка шаблона
	 *
	 * @param 	string 	$file 	Имя загружаемого файла
	 */
	public function load( $file )
	{
		$file = htmlspecialchars( strip_tags( trim( $file ) ) );
		$path = $this->dir . $file . '.tpl';

		if( !file_exists($path) ) {
			$this->tpl = $this->tpl_copy = "\r\n<br>Templates: <b>{$file}.tpl</b> - notfound.";
		} else $this->tpl = file_get_contents( $path );

		$this->tpl_copy = $this->tpl;
	}

	/**
	 * Установка параметра (переменной)
	 *
	 * @param 	string 	$name 	Имя переменной
	 * @param 	string 	$var 	Значение переменной
	 */
	public function set( $name, $var )
	{
		if( is_array( $var ) ) {
			if( count( $var ) ) {
				foreach ( $var as $key => $key_var ) {
					$this->set( $key, $key_var );
				}
			}
			return;
		}
		
		$var = str_replace( array("{", "["), array("_&#123;_", "_&#91;_"), $var);
			
		$this->data[$name] = $var;
	}

	/**
	 * Компиляция шаблона
	 *
	 * @param 	string 	$file 	Имя шаблона
	 */
	public function compile( $file )
	{	
		foreach ( $this->data as $key_find => $key_replace ) {
			$find[] = $key_find;
			$replace[] = $key_replace;
		}
		
		$this->tpl_copy = str_ireplace( $find, $replace, $this->tpl_copy );	
		$this->tpl_copy = str_replace( array("_&#123;_", "_&#91;_"), array("{", "["), $this->tpl_copy );
		
		if( isset( $this->result[$file] ) ) $this->result[$file] .= $this->tpl_copy;
		else $this->result[$file] = $this->tpl_copy;
		
		$this->clear();
	}

	/**
	 * Очистка шаблона
	 *
	 * @param 	boolean  $global 	Глобальная очистка
	 */
	public function clear( $global = false )
	{
		if( $global ) $this->tpl = null;
		$this->tpl_copy = $this->tpl;
		$this->data = array();
	}

}