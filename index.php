<?php
/**
 * Скрипт комментариев - главная
 * 
 * @author Alliline <inline-webb@yandex.ru>
 */

include_once __DIR__ . '/loader.php';

use ExportBase\Templates;
use ExportBase\Comments\CommentsController;

$comments = new CommentsController();

$tpl = new Templates();
$tpl->load( 'main' );

$tpl->set( '{comments}', $comments->view() );
$tpl->set( '{counter}', $comments->counter() );

$tpl->compile( 'main' );

echo $tpl->result['main'];

