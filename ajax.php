<?php
/**
 * Обработка асинхронных запросов
 * 
 * @author Alliline <inline-webb@yandex.ru>
 */

include_once __DIR__ . '/loader.php';

use ExportBase\Comments\CommentsAjax;

$comments = new CommentsAjax;
$action = isset($_REQUEST['action']) ? htmlspecialchars( strip_tags( trim( $_REQUEST['action'] ) ) ) : '';

if( !empty($action) && method_exists( $comments, $action ) ) {
	$result = $comments->$action();
}

if( !isset($result) || $result === false ) {
	$result = 'error';
}

echo $result;