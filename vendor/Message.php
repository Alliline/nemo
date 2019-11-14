<?php
/**
 * Информационные сообщения
 *
 * @author Alliline <inline-webb@yandex.ru>
 */

namespace ExportBase;

use ExportBase\Engine;
use ExportBase\Templates;

class Message
{

	/**
	 * Вывод информационного сообщения
	 *
	 * @param 	string 	$status Статус сообщения
	 * @param 	string 	$code 	Код сообщения
	 * @return 	string
	 */
	public static function view( $status, $code )
	{
		$status = in_array( $status, array('error', 'success', 'warning') ) ? $status : 'error';
		$text = isset( Engine::$lang[$code] ) ? Engine::$lang[$code] : Engine::$lang['error_none'];

		$tpl = new Templates;
		$tpl->load( 'message' );
		
		$tpl->set( '{text}', $text );
		$tpl->set( '{status}', $status );

		$tpl->compile( $status );

		return $tpl->result[$status];
	}
}